<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\event;

use phpbb\template\template;
use marttiphpbb\calendarmonthview\render\tag;
use phpbb\event\data as event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class tag_listener implements EventSubscriberInterface
{
	protected $template;
	protected $tag;

	public function __construct(template $template, tag $tag)
	{
		$this->template = $template;
		$this->tag = $tag;
	}

	static public function getSubscribedEvents()
	{
		return [

		];
	}

	public function core_posting_modify_template_vars(event $event)
	{
	}

}
