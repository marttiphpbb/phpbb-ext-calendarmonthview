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
	protected $segments = [];

	public function can_insert(calendar_event $calendar_event):bool
	{
		foreach ($this->segments as $c)
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
		$this->segments[] = $calendar_event;
	}

	public function get_segments():array
	{
		return $this->segments;
	}

	public function sort_and_fill(dayspan $dayspan):void
	{
		usort($this->segments, function(calendar_event $a, calendar_event $b){
			return $a->compare_start_with($b);
		});

		reset($this->segments);

		$segments = [];

		foreach($this->segments as $s)
		{
			if ($s->is_before($dayspan))
			{
				continue;
			}

			if ($s->is_after($dayspan))
			{
				if (!$s->touches($dayspan))
				{
					$segments[] = $dayspan->create_with_end_jd($s->get_jd_before());
				}
			}

			$segments[] = $s;

			if ($s->has_same_end($dayspan) || $s->ends_after($dayspan))
			{
				break;
			}

			$dayspan = $dayspan->create_with_start_jd($s->get_first_jd_after());
		}

		$this->segments = $segments;
	}

	public function get_segment(dayspan $dayspan):?dayspan
	{
		$segment = current($this->segments);

		if (!$segment)
		{
			return $dayspan;
		}

		return $segment;

		if ($segment->is_before($dayspan))
		{
		}


	}
}
