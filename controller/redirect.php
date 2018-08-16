<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\controller;

use phpbb\user;
use phpbb\controller\helper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class redirect
{
	protected $user;
	protected $helper;

	public function __construct(
		user $user,
		helper $helper
	)
	{
		$this->user = $user;
		$this->helper = $helper;
	}

	public function to_now():Response
	{
		$now = $this->user->create_datetime();
		$time_offset = $now->getOffset();
		$now = phpbb_gmgetdate($now->getTimestamp() + $time_offset);

		$link = $this->helper->route('marttiphpbb_calendarmonthview_page_controller', [
			'year'	=> $now['year'],
			'month'	=> $now['mon'],
		]);

		return RedirectResponse::create($link);
	}

	public function to_year(int $year):Response
	{
		$link = $this->helper->route('marttiphpbb_calendarmonthview_page_controller', [
			'year'	=> $year,
			'month'	=> 1,
		]);

		return RedirectResponse::create($link);
	}
}
