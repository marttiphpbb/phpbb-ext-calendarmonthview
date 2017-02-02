<?php

/**
* phpBB Extension - marttiphpbb calendar
* @copyright (c) 2014 - 2017 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendar\core;

use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\content_visibility;
use phpbb\db\driver\factory as db;

use marttiphpbb\calendar\core\timespan;
use marttiphpbb\calendar\core\calendar_event;
use marttiphpbb\calendar\core\calendar_event_row;

class event_container
{
	/* @var auth */
	protected $auth;

	/* @var config */
	protected $config;

	/* @var content_visibility */
	protected $content_visibility;

	/* @var db */
	protected $db;

	/* @var string */
	protected $topics_table;

	/* @var array */
	protected $events = [];

	/* @var array */
	protected $event_rows = [];

	/* @var timespan */
	protected $timespan;

	/**
	* @param auth				$auth
	* @param config				$config
	* @param content_visibility	$content_visibility
	* @param db   				$db
	* @param string				$topics_table
	*/
	public function __construct(
		auth $auth,
		config $config,
		content_visibility $content_visibility,
		db $db,
		$topics_table
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->content_visibility = $content_visibility;
		$this->db = $db;
		$this->topics_table = $topics_table;
	}

	/*
	 *
	 */
	public function set_timespan($timespan)
	{
		$this->timespan = $timespan;
		return $this;
	}

	/**
	*/
	public function fetch()
	{
		$events = array();

		$forum_ids = array_keys($this->auth->acl_getf('f_read', true));

		$sql = 'SELECT t.topic_id, t.forum_id, t.topic_reported, t.topic_title,
			t.topic_calendar_start, t.topic_calendar_end
			FROM ' . $this->topics_table . ' t
			WHERE ( t.topic_calendar_start <= ' . $this->timespan->get_end() . '
				AND t.topic_calendar_end >= ' . $this->timespan->get_start() . ' )
				AND ' . $this->db->sql_in_set('t.forum_id', $forum_ids, false, true) . '
				AND ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ids, 't.') . '
				AND t.topic_type IN (' . POST_NORMAL . ', ' . POST_STICKY . ')
			ORDER BY t.topic_calendar_start';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$calendar_event = new calendar_event();
			$timespan = new timespan($row['topic_calendar_start'], $row['topic_calendar_end']);
			$calendar_event->set_timespan($timespan)
				->set_topic_id($row['topic_id'])
				->set_forum_id($row['forum_id'])
				->set_topic_reported(($row['topic_reported']) ? true : false);
			$this->events[] = $calendar_event;
		}

		$this->db->sql_freeresult($result);

		return $this;
	}

	/*
	 * @return array
	 */
	public function get_events()
	{
		return $this->events;
	}

	/*
	 * @param int
	 */

	public function create_event_rows(int $num)
	{
		for($i = 0; $i < $num; $i++)
		{
			$this->event_rows[] = new calendar_event_row($this->timespan);
		}

		return $this;
	}

	/*
	 *
	 */
	public function arrange()
	{
		foreach ($this->events as $event)
		{
			$this->insert($event);
		}

		return $this;
	}

	/*
	 *
	 */
	public function insert($event)
	{
		foreach ($this->event_rows as $event_row)
		{
			if ($event_row->insert_calendar_event($event))
			{
				return;
			}
		}

		$new_event_row = new calendar_event_row($this->timespan);
		$new_event_row->insert_calendar_event($event);
		$this->event_rows[] = $new_event_row;

		return;
	}

}
