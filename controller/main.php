<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\controller;


use phpbb\event\dispatcher;
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
	protected $php_ext;
	protected $template;
	protected $language;
	protected $helper;
	protected $root_path;
	protected $now;
	protected $time_offset;
	protected $pagination;

	public function __construct(
		dispatcher $dispatcher,
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
			$dayspan = new dayspan($e['start_jd'], $e['end_jd']);
			$topic = new topic($e['topic_id'], $e['forum_id'], $e['topic_title'], $e['topic_reported']);
			$calendar_event = new calendar_event($topic, $dayspan);
			$row_container->add_calendar_event($calendar_event);
		}

		$tpl = [];

		$year_begin_jd = cal_to_jd(CAL_GREGORIAN, 1, 1, $year);
		$isoweek = gmdate('W', jdtounix($start_jd));

		for ($jd = $start_jd; $jd <= $end_jd; $jd++)
		{
			$day = cal_from_jd($jd, CAL_GREGORIAN);
			$day_of_year = $year_begin_jd - $jd + 1;

			if ($day['dayname'] === 'Monday')
			{
				$isoweek = gmdate('W', jdtounix($jd));
			}

			$month_abbrev = $day['abbrevmonth'] === 'May' ? 'May_short' : $day['abbrevmonth'];

			$day_tpl = [
				'JD'				=> $jd,
				'WEEKDAY'			=> $day['dow'],
				'WEEKDAY_NAME'		=> $this->language->lang(['datetime', $day['dayname']]),
				'WEEKDAY_ABBREV'	=> $this->language->lang(['datetime', $day['abbrevdayname']]),
				'MONTHDAY'			=> $day['day'],
				'MONTH'				=> $day['month'],
				'MONTH_NAME'		=> $this->language->lang(['datetime', $day['monthname']]),
				'MONTH_ABBREV'		=> $this->language->lang(['datetime', $month_abbrev]),
				'YEAR'				=> $day['year'],
				'ISOWEEK'			=> $isoweek,
				'COLUMN'			=> $col,
			];

			$tpl[] = $day_tpl;

			$col++;
		}

		$event_row_count = $row_container->get_row_count();

		foreach($tpl as $day => $tpl)
		{
			if (isset($tpl['week']))
			{
				$this->template->assign_block_vars('week', $tpl['week']);

				for($evrow = 0; $evrow < $event_row_count; $evrow++)
				{
					$this->template->assign_block_vars('week.eventrow', $tpl['week']);

					for($d7 = 0; $d7 < 7; $d7++)
					{
						$d = $day + $d7;
						$this->template->assign_block_vars('week.eventrow.day', $day_tpl[$d]['day']);
					}
				}
			}

			$this->template->assign_block_vars('week.day', []);
		}

		$day = cal_from_jd($month_start_jd, CAL_GREGORIAN);
		$month_abbrev = $day['abbrevmonth'] === 'May' ? 'May_short' : $day['abbrevmonth'];

		$this->template->assign_vars([
			'MONTH'			=> $month,
			'MONTH_NAME'	=> $this->language->lang(['datetime', $day['monthname']]),
			'MONTH_ABBREV'	=> $this->language->lang(['datetime', $month_abbrev]),
			'YEAR'			=> $year,
		]);

		$this->pagination->render($year, $month);
		$this->language->add_lang('calendar_page', cnst::FOLDER);

		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));

		return $this->helper->render('month.html');
	}
}
