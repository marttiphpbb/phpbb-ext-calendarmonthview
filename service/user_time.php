<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\service;

use phpbb\user;

class user_time
{
	protected $user;
	protected $format;

	public function __construct(
		user $user
	)
	{
		$this->user = $user;
	}

	public function get(int $time):string
	{
		if (!$this->format)
		{
			$this->find_format();
		}

		return $this->user->format_date($time, $this->format);
	}

	public function find_format()
	{
		$user_date_format = $this->user->date_format;

		$i_pos = strpos($user_date_format, 'i');

		if ($i_pos === false)
		{
			$this->format = 'H:i';
			return;
		}

		$a_pos = stripos($user_date_format, 'a');
		$g_pos = stripos($user_date_format, 'g');
		$h_pos = stripos($user_date_format, 'h');

		$x_pos = $g_pos === false ? $h_pos : $g_pos;

		if ($x_pos === false || $i_pos <= $x_pos)
		{
			$this->format = 'H:i';
			return;
		}

		$this->format = substr($user_date_format, $x_pos, $i_pos - $x_pos + 1);

		if ($a_pos !== false)
		{
			$this->format .= ' ';
			$this->format .= substr($user_date_format, $a_pos, 1);
		}
	}
}
