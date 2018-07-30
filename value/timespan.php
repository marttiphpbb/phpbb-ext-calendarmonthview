<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\value;

class timespan
{
	protected $start; // in unix time
	protected $end;

	public function __construct(int $start, int $end)
	{
		$this->start = $start;
		$this->end = $end;
	}

	public function fits_in(timespan $timespan):bool
	{
		return $this->start >= $timespan->get_start() && $this->end <= $timespan->get_end() ? true : false;
	}

	public function contains(timespan $timespan):bool
	{
		return $this->start <= $timespan->get_start() && $this->end >= $timespan->get_end() ? true : false;
	}

	public function overlaps(timespan $timespan):bool
	{
		return $this->start <= $timespan->get_end() && $this->end >= $timespan->get_start() ? true : false;
	}

	public function fits_after_start(timespan $timespan):bool
	{
		return $this->start <= $timespan->get_start() ? true : false;
	}

	public function fits_before_end(timespan $timespan):bool
	{
		return $this->end >= $timespan->get_end() ? true : false;
	}

	public function starts_before(timespan $timespan):bool
	{
		return $this->start > $timespan->get_start() ? true : false;
	}

	public function ends_after(timespan $timespan):bool
	{
		return $this->end < $timespan->get_end() ? true : false;
	}

	public function is_after(timespan $timespan):bool
	{
		return $this->start > $timespan->get_end() ? true : false;
	}

	public function is_before(timespan $timespan):bool
	{
		return $this->end < $timespan->get_start() ? true : false;
	}

	public function has_same_start(timespan $timespan):bool
	{
		return $timespan->get_start() === $this->start ? true : false;
	}

	public function has_same_end(timespan $timespan):bool
	{
		return $timespan->get_end() === $this->end ? true : false;
	}

	public function get_duration():int
	{
		return $this->end - $this->start;
	}

	public function get_start():int
	{
		return $this->start;
	}

	public function get_end():int
	{
		return $this->end;
	}
}
