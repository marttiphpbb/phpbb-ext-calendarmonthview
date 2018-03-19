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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …

/*
* These are errors which can be triggered by sending invalid data to the
* calendarmonthview extension API.
*
* These errors will never show to a user unless they are either modifying
* the core reputation extension code OR unless they are writing an extension
* which makes calls to this extension.
*
* Translators: Feel free to not translate these language strings
*/

$lang = array_merge($lang, [

	'EXCEPTION_FIELD_MISSING'		=> 'required field missing',
	'EXCEPTION_INVALID_ARGUMENT'	=> 'Invalid argument specified for `%1$s`. Reason: %2$s.',
	'EXCEPTION_OUT_OF_BOUNDS'		=> 'The field `%1$s` received data beyond its bounds',

]);
