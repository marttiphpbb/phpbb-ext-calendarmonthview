<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\core;

use marttiphpbb\calendarmonthview\core\timespan;
use marttiphpbb\calendarmonthview\core\calendarmonthview_event;

class calendarmonthview_event_row
{
	/* @var timespan  */
	protected $timespan;

	/* @var array */
	protected $free_timespans = [];

	/* @var array */
	protected $calendarmonthview_events = [];

	/**
	 * @param timespan $timespan
	 */

	public function __construct(
		timespan $timespan
	)
	{
		$this->timespan = $timespan;
		$this->free_timespans = [$timespan];
	}

	/*
	*/
	public function insert_calendarmonthview_event(calendarmonthview_event $calendarmonthview_event)
	{
		$timespan = $calendarmonthview_event->get_timespan();

		foreach ($this->calendarmonthview_events as $ev)
		{
			if ($ev->overlaps($timespan))
			{
				return false;
			}
		}

		$this->calendarmonthview_events[] = $calendarmonthview_event;

		return true;
	}
}
