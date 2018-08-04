<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\core;

use marttiphpbb\calendarmonthview\core\dayspan;
use marttiphpbb\calendarmonthview\core\calendar_event;

class calendar_event_row
{
	protected $dayspan;
	protected $free_dayspans = [];
	protected $calendar_events = [];

	public function __construct(
		dayspan $dayspan
	)
	{
		$this->dayspan = $dayspan;
		$this->free_dayspans = [$dayspan];
	}

	public function insert_calendar_event(calendar_event $calendar_event)
	{
		$dayspan = $calendar_event->get_dayspan();

		foreach ($this->calendar_events as $ev)
		{
			if ($ev->overlaps($dayspan))
			{
				return false;
			}
		}

		$this->calendar_events[] = $calendar_event;

		return true;
	}
}
