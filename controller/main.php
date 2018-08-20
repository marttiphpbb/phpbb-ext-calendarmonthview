<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\controller;

use phpbb\event\dispatcher;
use phpbb\request\request;
use phpbb\template\twig\twig as template;
use phpbb\language\language;
use phpbb\controller\helper;
use marttiphpbb\calendarmonthview\render\row_container;
use marttiphpbb\calendarmonthview\value\topic;
use marttiphpbb\calendarmonthview\value\dayspan;
use marttiphpbb\calendarmonthview\value\calendar_event;
use marttiphpbb\calendarmonthview\service\store;
use marttiphpbb\calendarmonthview\service\pagination;
use marttiphpbb\calendarmonthview\util\cnst;
use Symfony\Component\HttpFoundation\Response;

class main
{
	protected $dispatcher;
	protected $request;
	protected $php_ext;
	protected $template;
	protected $language;
	protected $helper;
	protected $root_path;
	protected $pagination;

	public function __construct(
		dispatcher $dispatcher,
		request $request,
		string $php_ext,
		template $template,
		language $language,
		helper $helper,
		string $root_path,
		pagination $pagination,
		store $store
	)
	{
		$this->dispatcher = $dispatcher;
		$this->request = $request;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->language = $language;
		$this->helper = $helper;
		$this->root_path = $root_path;
		$this->pagination = $pagination;
		$this->store = $store;
	}

	public function page(int $year, int $month):Response
	{
		$month_start_jd = cal_to_jd(CAL_GREGORIAN, $month, 1, $year);
		$month_days_num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$month_end_jd = $month_start_jd + $month_days_num;
		$month_start_weekday = jddayofweek($month_start_jd);

		$first_weekday = $this->store->get_first_weekday();
		$days_prefill = $month_start_weekday - $first_weekday;
		$days_prefill += $days_prefill < 0 ? 7 : 0;

		$days_postfill = 7 - (($month_days_num + $days_prefill) % 7);
		$days_postfill = $days_postfill == 7 ? 0 : $days_postfill;

		$start_jd = $month_start_jd - $days_prefill;
		$end_jd = $month_end_jd + $days_postfill;
		$days_num = $end_jd - $start_jd;

		$events = [];

		/**
		 * Event to fetch the calendar events for the view
		 *
		 * @event
		 * @var int 	start_jd	start julian day of the view
		 * @var int 	end_jd		end julian day of the view
		 * @var array   events      items should contain
		 * start_jd, end_jd, topic_id, forum_id, topic_title, topic_reported
		 */
		$vars = ['start_jd', 'end_jd', 'events'];
		extract($this->dispatcher->trigger_event('marttiphpbb.calendar.view', compact($vars)));

		$row_container = new row_container($this->store->get_min_rows());

		foreach($events as $e)
		{
			$topic = new topic($e['topic_id'], $e['forum_id'], $e['topic_title'], $e['topic_reported']);
			$calendar_event = new calendar_event($e['start_jd'], $e['end_jd'], $topic, $dayspan);
			$row_container->add_calendar_event($calendar_event);
		}

		$col = 0;

		$year_begin_jd = cal_to_jd(CAL_GREGORIAN, 1, 1, $year);
		$row_container->sort_and_reset();
		$rows = $row_container->get_rows();

		for ($jd = $start_jd; $jd <= $end_jd; $jd++)
		{
			$first_day = !$col;
			$weekcol = $col % 7;
			$day = cal_from_jd($jd, CAL_GREGORIAN);

			if ($day['dayname'] === 'Monday' || $first_day)
			{
				$isoweek = gmdate('W', jdtounix($jd));
			}

			if ($day['day'] === 1 || $first_day)
			{
				$month_abbrev = $day['abbrevmonth'] === 'May' ? 'May_short' : $day['abbrevmonth'];
				$month_abbrev = $this->language->lang(['datetime', $month_abbrev]);
				$month_name = $this->language->lang(['datetime', $day['monthname']]);

				if ($month === $day['month'])
				{
					$this->template->assign_vars([
						'MONTH'				=> $month,
						'MONTH_NAME'		=> $this->language->lang(['datetime', $day['monthname']]),
						'MONTH_ABBREV'		=> $this->language->lang(['datetime', $month_abbrev]),
						'YEAR'				=> $year,
						'TOPIC_HILIT'		=> $this->request->variable('t', 0),
						'S_SHOW_ISOWEEK'	=> $this->store->get_show_isoweek(),
					]);
				}
			}

			if (!$weekcol)
			{
				$this->template->assign_block_vars('weeks', []);

				foreach($rows as $row)
				{
					$this->template->assign_block_vars('weeks.rows', []);

					$seg_start_jd = $jd;
					$seg_end_jd = $jd + 6;

					while($segment = $row->get_segment(new dayspan($seg_start_jd, $seg_end_jd)))
					{
						if ($segment instanceof calendar_event)
						{
							$topic = $segment->get_topic();
							$params = [
								't'		=> $topic->get_topic_id(),
								'f'		=> $topic->get_forum_id(),
							];
							$link = append_sid($this->root_path . 'viewtopic.' . $this->php_ext, $params);

							$this->template->assign_block_vars('weeks.rows.segments', [
								'TOPIC_ID'			=> $topic->get_topic_id(),
								'FORUM_ID'			=> $topic->get_forum_id(),
								'TOPIC_TITLE'		=> $topic->get_topic_title(),
								'TOPIC_APPROVED'	=> $topic->get_topic_approved(),
								'TOPIC_LINK'		=> $link,
								'FLEX'				=> $segment->get_flex(),
							]);
						}
						else if ($segment instanceof dayspan)
						{
							$this->template->assign_block_vars('weeks.rows.segments', [
								'FLEX'		=> $segment,
							]);
						}

						$seg_start_jd = $segment->get_end_jd() + 1;

						if ($seg_start_jd > $seg_end_jd)
						{
							break;
						}
					}
				}
			}

			$this->template->assign_block_vars('weeks.days', [
				'JD'				=> $jd,
				'WEEKDAY'			=> $day['dow'],
				'WEEKDAY_NAME'		=> $this->language->lang(['datetime', $day['dayname']]),
				'WEEKDAY_ABBREV'	=> $this->language->lang(['datetime', $day['abbrevdayname']]),
				'MONTHDAY'			=> $day['day'],
				'MONTH'				=> $month,
				'MONTH_NAME'		=> $month_name,
				'MONTH_ABBREV'		=> $month_abbrev,
				'YEAR'				=> $day['year'],
				'YEARDAY'			=> $year_begin_jd - $jd + 1,
				'ISOWEEK'			=> $isoweek,
				'COL'				=> $col,
				'WEEKCOL'			=> $weekcol,
			]);

			$col++;
		}

		$this->pagination->render($year, $month);
		$this->language->add_lang('calendar_page', cnst::FOLDER);

		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));

		return $this->helper->render('month.html');
	}
}
