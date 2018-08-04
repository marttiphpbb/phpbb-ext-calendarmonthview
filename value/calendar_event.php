<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\value;

use marttiphpbb\calendarmonthview\value\topic;
use marttiphpbb\calendarmonthview\value\dayspan;

class calendar_event
{
	protected $topic;
	protected $dayspan;

	public function __construct(
		topic $topic,
		dayspan $dayspan
	)
	{
		$this->topic = $topic;
		$this->dayspan = $dayspan;
	}

	public function get_topic():topic
	{
		return $this->topic;
	}

	public function get_dayspan():dayspan
	{
		return $this->dayspan;
	}
}
