<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\render;

use marttiphpbb\calendarmonthview\value\dayspan;
use marttiphpbb\calendarmonthview\value\calendar_event;

class calendar_event_row
{
	protected $calendar_events = [];

	public function can_insert(calendar_event $calendar_event):bool
	{
		$dayspan = $calendar_event->get_dayspan();

		foreach ($this->calendar_events as $calendar_event)
		{
			if ($calendar_event->get_dayspan()->overlaps($dayspan))
			{
				return false;
			}
		}

		return true;
	}

	public function insert(calendar_event $calendar_event):void
	{
		$this->calendar_events[] = $calendar_event;
	}

	public function get_calendar_events():array
	{
		return $this->calendar_events;
	}
}
