<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\controller;

use phpbb\auth\auth;
use phpbb\cache\service as cache;
use phpbb\config\db as config;
use phpbb\db\driver\factory as db;
use phpbb\request\request;
use phpbb\template\twig\twig as template;
use phpbb\user;
use phpbb\language\language;
use phpbb\controller\helper;

use marttiphpbb\calendarmonthview\render\row_container;
use marttiphpbb\calendarmonthview\value\topic;
use marttiphpbb\calendarmonthview\value\dayspan;
use marttiphpbb\calendarmonthview\value\calendar_event;

use marttiphpbb\calendarmonthview\render\pagination;


use Symfony\Component\HttpFoundation\Response;

class main
{
	protected $auth;
	protected $cache;
	protected $config;
	protected $now;
	protected $event_container;
	protected $time_offset;
	protected $pagination;

	public function __construct(
		auth $auth,
		cache $cache,
		config $config,
		db $db,
		string $php_ext,
		request $request,
		template $template,
		user $user,
		language $language,
		helper $helper,
		string $root_path,
		event_container $event_container,
		pagination $pagination
	)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->php_ext = $php_ext;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->helper = $helper;
		$this->root_path = $root_path;
		$this->event_container = $event_container;
		$this->pagination = $pagination;
	}

	public function redirect():Response
	{
		$now = $user->create_datetime();
		$time_offset = $now->getOffset();
		$now = phpbb_gmgetdate($now->getTimestamp() + $time_offset);

// to do redirect
		return $this->page($now['year'], $now['mon']);
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

		$days_endfill = 7 - (($month_days_num + $days_prefill) % 7);
		$days_endfill = $days_endfill == 7 ? 0 : $days_endfill;

		$start_jd = $month_start_jd - $days_prefill;
		$end_jd = $month_end_jd + $days_endfill;
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

		$row_container = new row_container();

		foreach($events as $e)
		{
			$dayspan = new dayspan($e['start_jd'], $e['end_jd']);
			$topic = new topic($e['topic_id'], $e['forum_id'], $e['topic_title'], $e['topic_reported']);
			$calendar_event = new calendar_event($topic, $dayspan);
			$row_container->add_calendar_event($calendar_event);
		}

		$mday = 1;
		$mday_total = 0;

		$dayspan = new dayspan($start - $this->time_offset, $end - $this->time_offset);

		$this->event_container->set_dayspan($dayspan)
			->fetch()
			->create_event_rows($this->store->get_min_rows())
			->arrange();

		$day_tpl = [];

		$time = $start;

		$col = 0;

		$year_begin_jd = cal_to_jd(CAL_GREGORIAN, 1, 1, $year);
		$start_unix = jdtounix($start_jd);
		$year_weekday = jddayofweek($year_begin_jd);

		for ($jd = $start_jd; $jd <= $end_jd; $jd++)
		{
			$day = cal_from_jd($jd, CAL_GREGORIAN);
			$day_of_year = $year_begin_jd - $jd + 1;
			$isoweek = ($day_of_year + 6) / 7;
			$isoweek += $day['dow'] < $year_weekday ? 1 : 0;

/*
			int julian = getDayOfYear(myDate)  // Jan 1 = 1, Jan 2 = 2, etc...
			int dow = getDayOfWeek(myDate)     // Sun = 0, Mon = 1, etc...
			int dowJan1 = getDayOfWeek("1/1/" + thisYear)   // find out first of year's day
			// int badWeekNum = (julian / 7) + 1  // Get our week# (wrong!  Don't use this)
			int weekNum = ((julian + 6) / 7)   // probably better.  CHECK THIS LINE. (See comments.)
			if (dow < dowJan1)                 // adjust for being after Saturday of week #1
				++weekNum;
			return (weekNum)

			To clarify, this algorithm assumes you number your weeks like this:

			S  M  T  W  R  F  S
						1  2  3    <-- week #1
			4  5  6  7  8  9 10    <-- week #2
			[etc.]
*/

			if (!$wday)
			{
				$day_tpl[$day]['week'] = [
					'ISOWEEK'  => gmdate('W', $time + 86400),
				];
			}

			if ($mday > $mday_total)
			{
				$mday = gmdate('j', $time);
				$mday_total = gmdate('t', $time);
				$mon = gmdate('n', $time);
			}

			$day_end_time = $time + 86399;

			$weekday_abbrev = gmdate('D', $time);
			$weekday_name = gmdate('l', $time);

			$day_template = [
				'CLASS' 	=> strtolower($weekday_abbrev),
				'NAME'		=> $this->language->lang(['datetime', $weekday_name]),
				'ABBREV'	=> $this->language->lang(['datetime', $weekday_abbrev]),
				'MDAY'		=> $mday,
				'S_TODAY'	=> $this->now['year'] == $year && $this->now['mon'] == $mon && $this->now['mday'] == $mday ? true : false,
				'S_BLUR'	=> $mon != $month ? true : false,
			];

			$day_tpl[$day]['day'] = $day_template;

			$mday++;
			$time += 86400;
		}

		$event_row_num = $this->event_container->get_row_num();

		foreach($day_tpl as $day => $tpl)
		{
			if (isset($tpl['week']))
			{
				$this->template->assign_block_vars('week', $tpl['week']);

				for($evrow = 0; $evrow < $event_row_num; $evrow++)
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

		$this->template->assign_vars([
			'MONTH'			=> $this->user->format_date($month_start_time, 'F', true),
			'YEAR'			=> $year,
			'U_YEAR'		=> $this->helper->route('marttiphpbb_calendarmonthview_yearview_controller', [
				'year' => $year]),
		]);

		$this->pagination->render($year, $month);

		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));

		return $this->helper->render('month.html');
	}
}
