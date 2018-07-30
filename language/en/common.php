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

	'CALENDARMONTHVIEW'						=> 'Calendar',
	'CALENDARMONTHVIEW_EXTENSION'			=> '%sCalendar%s extension for phpBB',

// viewonline
	'CALENDARMONTHVIEW_VIEWING'			=> 'Viewing Calendar',

// Calendar page

	'CALENDARMONTHVIEW_NEW_MOON'			=> 'New moon@%s',
	'CALENDARMONTHVIEW_FIRST_QUARTER_MOON'	=> 'First quarter moon@%s',
	'CALENDARMONTHVIEW_FULL_MOON'			=> 'Full moon@%s',
	'CALENDARMONTHVIEW_THIRD_QUARTER_MOON'	=> 'Third quarter moon%s',
]);
