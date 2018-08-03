<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\event;

use phpbb\controller\helper;
use phpbb\template\template;
use marttiphpbb\calendarmonthview\render\tag;
use phpbb\event\data as event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class tag_listener implements EventSubscriberInterface
{
	protected $helper;

	public function __construct(helper $helper)
	{
		$this->helper = $helper;
	}

	static public function getSubscribedEvents()
	{
		return [
			'marttiphpbb.calendartag.link'	=> 'link',
		];
	}

	public function link(event $event)
	{
		$link = $event['link'];
		$year = $event['year'];
		$month = $event['month'];

		if ($link)
		{
			return;
		}

		$link = $this->helper->route('marttiphpbb_calendarmonthview_controller', [
				'year'	=> $year,
				'month'	=> $month,
			]);

		$event['link'] = $link;
	}
}
