<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\value;

class topic
{
	protected $topic_id;
	protected $forum_id;
	protected $topic_title;
	protected $topic_reported;

	public function __construct(
		int $topic_id,
		int $forum_id,
		string $topic_title,
		bool $topic_reported
	)
	{
		$this->topic_id = $topic_id;
		$this->forum_id = $forum_id;
		$this->topic_title = $topic_title;
		$this->topic_reported = $topic_reported;
	}

	public function get_topic_id():int
	{
		return $this->topic_id;
	}

	public function get_forum_id():int
	{
		return $this->forum_id;
	}

	public function get_topic_title():string
	{
		return $this->topic_title;
	}

	public function get_topic_reported():bool
	{
		return $this->topic_reported;
	}
}
