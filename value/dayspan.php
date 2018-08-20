<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\value;

class dayspan
{
	protected $start_jd;
	protected $end_jd;

	public function __construct(int $start_jd, int $end_jd)
	{
		$this->start_jd = $start_jd;
		$this->end_jd = $end_jd;
	}

	public function fits_in(dayspan $dayspan):bool
	{
		return $this->start_jd >= $dayspan->get_start_jd() && $this->end_jd <= $dayspan->get_end_jd() ? true : false;
	}

	public function contains(dayspan $dayspan):bool
	{
		return $this->start_jd <= $dayspan->get_start_jd() && $this->end_jd >= $dayspan->get_end_jd() ? true : false;
	}

	public function overlaps(dayspan $dayspan):bool
	{
		return $this->start_jd <= $dayspan->get_end_jd() && $this->end_jd >= $dayspan->get_start_jd() ? true : false;
	}

	public function fits_after_start(dayspan $dayspan):bool
	{
		return $this->start_jd <= $dayspan->get_start_jd() ? true : false;
	}

	public function fits_before_end(dayspan $dayspan):bool
	{
		return $this->end_jd >= $dayspan->get_end_jd() ? true : false;
	}

	public function starts_before(dayspan $dayspan):bool
	{
		return $this->start_jd > $dayspan->get_start_jd() ? true : false;
	}

	public function ends_after(dayspan $dayspan):bool
	{
		return $this->end_jd < $dayspan->get_end_jd() ? true : false;
	}

	public function is_after(dayspan $dayspan):bool
	{
		return $this->start_jd > $dayspan->get_end_jd() ? true : false;
	}

	public function is_before(dayspan $dayspan):bool
	{
		return $this->end_jd < $dayspan->get_start_jd() ? true : false;
	}

	public function has_same_start(dayspan $dayspan):bool
	{
		return $dayspan->get_start_jd() === $this->start_jd ? true : false;
	}

	public function has_same_end(dayspan $dayspan):bool
	{
		return $dayspan->get_end_jd() === $this->end_jd ? true : false;
	}

	public function get_duration():int
	{
		return $this->end_jd - $this->start_jd;
	}

	public function compare_start_with(dayspan $dayspan):int
	{
		return $this->start_jd <=> $dayspan->get_start_jd();
	}

	public function get_start_jd():int
	{
		return $this->start_jd;
	}

	public function get_end_jd():int
	{
		return $this->end_jd;
	}
}
