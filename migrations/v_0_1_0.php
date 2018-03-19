<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\migrations;

class v_0_1_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return [

			['config.add', ['calendarmonthview_first_weekday', 0]],
			['config.add', ['calendarmonthview_links', 2]],
			['config.add', ['calendarmonthview_render_settings', 7]],
			['config.add', ['calendarmonthview_min_rows', 5]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_CALENDARMONTHVIEW'
			]],
			['module.add', [
				'acp',
				'ACP_CALENDARMONTHVIEW',
				[
					'module_basename'	=> '\marttiphpbb\calendarmonthview\acp\main_module',
					'modes'				=> [
						'links',
						'page_rendering',
					],
				],
			]],
		];
	}
}
