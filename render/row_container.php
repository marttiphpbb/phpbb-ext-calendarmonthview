<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\render;

use marttiphpbb\calendarmonthview\value\calendar_event;
use marttiphpbb\calendarmonthview\render\calendar_event_row;

class row_container
{
	protected $rows = [];

	public function add_calendar_event(calendar_event $calendar_event):void
	{
		for($row_index = 0; $row_index < 50; $row_index++)
		{
			if (!$this->rows[$row_index])
			{
				$this->rows[$row_index] = new calendar_event_row();
			}

			$row = $this->rows[$row_index];

			if ($row->can_insert($calendar_event))
			{
				$row->insert($calendar_event);
				return;
			}
		}
	}

	public function get_rows():array
	{
		return $this->rows;
	}
}
