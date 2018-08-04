<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\event;

use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\event\data as event;
use marttiphpbb\calendarmonthview\util\cnst;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected $helper;
	protected $php_ext;
	protected $template;
	protected $language;

	public function __construct(
		helper $helper,
		string $php_ext,
		template $template,
		language $language
	)
	{
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->language = $language;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'						=> 'core_user_setup',
			'core.page_header'						=> 'core_page_header',
			'core.viewonline_overwrite_location'	=> 'core_viewonline_overwrite_location',
		];
	}

	public function core_user_setup(event $event)
	{
/*		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => cnst::FOLDER,
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext; */
	}

	public function core_page_header(event $event)
	{
/*
		$this->template->assign_vars([
			'U_MARTTIPHPBB_CALENDARMONTHVIEW'			=> $this->helper->route('marttiphpbb_calendarmonthview_defaultview_controller'),
		]); */
	}

	public function core_viewonline_overwrite_location(event $event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/calendarmonthview') === 0)
		{
			$event['location'] = $this->language->lang(cnst::L . '_VIEWING');
			$event['location_url'] = $this->helper->route('marttiphpbb_calendarmonthview_defaultview_controller');
		}
	}

}
