<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\migrations;

use marttiphpbb\calendarmonthview\util\cnst;

class mgr_2 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\calendarmonthview\migrations\mgr_1',
		];
	}

	public function update_data()
	{
		$data = [
			'first_weekday'			=> 0,
			'min_rows'				=> 5,
			'show_today'			=> true,
			'show_isoweek'			=> false,
			'hilit_topic'			=> false,
			'pag_neighbours'		=> 2,
			'pag_show_prev_next'	=> true,
			'load_stylesheet'		=> true,
			'extra_stylesheet'		=> '',
		];

		return [
			['config_text.add', [cnst::ID, serialize($data)]],
		];
	}
}
