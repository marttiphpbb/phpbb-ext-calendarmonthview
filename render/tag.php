<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\render;

use phpbb\controller\helper;
use marttiphpbb\calendarmonthview\util\dateformat;

class tag
{
	protected $helper;
	protected $dateformat;

	public function __construct(helper $helper, dateformat $dateformat)
	{
		$this->helper = $helper;
		$this->dateformat = $dateformat;
	}

	public function get(array $input):array
	{
		$start = $input['topic_calendarmonthview_start'];

		if (!$start)
		{
			return [];
		}

		$end = $input['topic_calendarmonthview_end'];

		$year = gmdate('Y', $start);
		$month = gmdate('n', $start);

		return [
			'CALENDARMONTHVIEW_TAG_URL' => $this->helper->route('marttiphpbb_calendarmonthview_monthview_controller', ['year' => $year, 'month' => $month]),
			'CALENDARMONTHVIEW_TAG' => $this->dateformat->get_period($start, $end),
		];
	}
}
