<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\core;

use marttiphpbb\calendarmonthview\core\timespan;

class calendarmonthview_event
{
	protected $id;
	protected $timespan;
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

	public function set_timespan(timespan $timespan)
	{
		$this->timespan = $timespan;
		return $this;
	}

	public function get_timespan():timespan
	{
		return $this->timespan;
	}

	public function overlaps(timespan $timespan)
	{
		return $this->timespan->overlaps($timespan);
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
