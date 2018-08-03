<?php

/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [

	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_SETTINGS_SAVED'
	=> 'The settings have been saved successfully!',

// links
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_LINKS'
	=> 'Links',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_LINK_LOCATIONS'
	=> 'Link locations to the Calendar page',

// page_rendering
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_PAGE'
	=> 'Calendar page',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_ISOWEEK'
	=> 'Display the week number (ISO 1806)',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_ISOWEEK_EXPLAIN'
	=> 'According to ISO 1806, the first day of the week is defined monday.',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_TODAY'
	=> 'Mark today´s date',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_SELECT_FIRST_WEEKDAY'
	=> 'First day of the week',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_MIN_ROWS'
	=> 'Minumum rows of the Calendar table',
	'ACP_MARTTIPHPBB_CALENDARMONTHVIEW_MIN_ROWS_EXPLAIN'
	=> '',
]);
