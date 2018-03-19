<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\calendarmonthview\acp\main_module',
			'title'		=> 'ACP_CALENDARMONTHVIEW',
			'modes'		=> [
				'links'	=> [
					'title' => 'ACP_CALENDARMONTHVIEW_LINKS',
					'auth' => 'ext_marttiphpbb/calendarmonthview && acl_a_board',
					'cat' => ['ACP_CALENDARMONTHVIEW'],
				],
				'page_rendering'	=> [
					'title' => 'ACP_CALENDARMONTHVIEW_PAGE_RENDERING',
					'auth' => 'ext_marttiphpbb/calendarmonthview && acl_a_board',
					'cat' => ['ACP_CALENDARMONTHVIEW'],
				],
			],
		];
	}
}
