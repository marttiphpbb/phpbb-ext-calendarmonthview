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

		foreach ($this->calendar_events as $c)
		{
			if ($c->overlaps($calendar_event))
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

	public function sort_and_reset():void
	{
		usort($this->calendar_events, function(calendar_event $a, calendar_event $b){
			return $a->compare_start_with($b);
		});

		reset($this->calendar_events);
	}

	public function get_segment(dayspan $dayspan):?dayspan
	{
		$segment = current($this->calendar_events);

		if (!$segment)
		{
			return $dayspan;
		}

		if ($segment->is_before($dayspan))
		{
		}


	}
}
