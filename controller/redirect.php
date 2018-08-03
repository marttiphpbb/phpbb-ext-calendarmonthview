<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\controller;

use phpbb\auth\auth;
use phpbb\user;
use phpbb\controller\helper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class redirect
{
	protected $auth;
	protected $user;
	protected $config;

	public function __construct(
		auth $auth,
		user $user,
		helper $helper
	)
	{
		$this->auth = $auth;
		$this->user = $user;
		$this->helper = $helper;

		$now = $user->create_datetime();
		$this->time_offset = $now->getOffset();
		$this->now = phpbb_gmgetdate($now->getTimestamp() + $this->time_offset);
	}

	public function redirect():Response
	{
		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));
		return $this->monthview($this->now['year'], $this->now['mon']);
	}
}
