<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\event;

use phpbb\controller\helper;
use phpbb\event\data as event;
use phpbb\user;
use phpbb\auth\auth;
use marttiphpbb\calendarmonthview\util\cnst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class menu_listener implements EventSubscriberInterface
{
	protected $helper;
	protected $user;
	protected $auth;

	public function __construct(
		helper $helper,
		user $user,
		auth $auth
	)
	{
		$this->helper = $helper;
		$this->user = $user;
		$this->auth = $auth;
	}

	static public function getSubscribedEvents()
	{
		return [
			'marttiphpbb.menuitems.add_items'	=> 'add_items',
		];
	}

	public function add_items(event $event)
	{
		$items = $event['items'];

		if ($link)
		{
			return;
		}

		$year = '2018';
		$month = '8';

		$link = $this->helper->route('marttiphpbb_calendarmonthview_page_controller', [
			'year'	=> $year,
			'month'	=> $month,
		]);

		$items[cnst::FOLDER]['links'] = [
			'link'		=> $link,
			'include'	=> cnst::TPL . 'include/menu_item.html',
		];

		$event['items'] = $items;
	}
}
