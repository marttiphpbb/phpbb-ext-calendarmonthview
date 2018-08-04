<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\core;

use marttiphpbb\calendarmonthview\core\dayspan;

class calendar_event
{
	protected $id;
	protected $dayspan;
	protected $topic_id;
	protected $forum_id;
	protected $topic_reported;
	protected $topic_title;

	public function __construct()
	{
	}

	public function set_id(int $id)
	{
		$this->id = $id;
		return $this;
	}

	public function get_id():int
	{
		return $this->id;
	}

	public function set_dayspan(dayspan $dayspan)
	{
		$this->dayspan = $dayspan;
		return $this;
	}

	public function get_dayspan():dayspan
	{
		return $this->dayspan;
	}

	public function overlaps(dayspan $dayspan)
	{
		return $this->dayspan->overlaps($dayspan);
	}

	public function set_topic_id($topic_id)
	{
		$this->topic_id = $topic_id;
		return $this;
	}

	public function get_topic_id()
	{
		return $this->topic_id;
	}

	public function set_forum_id($forum_id)
	{
		$this->forum_id = $forum_id;
		return $this;
	}

	public function get_forum_id()
	{
		return $this->forum_id;
	}

	public function set_topic_reported($topic_reported)
	{
		$this->topic_reported = $topic_reported;
		return $this;
	}

	public function get_topic_reported()
	{
		return $this->topic_reported;
	}
}
