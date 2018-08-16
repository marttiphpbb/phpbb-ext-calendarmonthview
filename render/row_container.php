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
	protected $max_rows = 50;

	public function __construct(int $min_rows = 0)
	{
		for ($row_index = 0; $row_index < $min_rows; $row_index++)
		{
			$this->get_or_create_row($row_index);
		}
	}

	private function get_or_create_row(int $row_index):calendar_event_row
	{
		if (!$this->rows[$row_index])
		{
			$this->rows[$row_index] = new calendar_event_row();
		}

		return $this->rows[$row_index];
	}

	public function set_max_rows(int $max_rows):void
	{
		$this->max_rows = $max_rows;
	}

	public function add_calendar_event(calendar_event $calendar_event):void
	{
		for($row_index = 0; $row_index < $this->max_rows; $row_index++)
		{
			$row = $this->get_or_create_row($row_index);

			if ($row->can_insert($calendar_event))
			{
				$row->insert($calendar_event);
				return;
			}
		}
	}

	public function get_row_count():int
	{
		return count($this->rows);
	}

	public function get_rows():array
	{
		return $this->rows;
	}
}
