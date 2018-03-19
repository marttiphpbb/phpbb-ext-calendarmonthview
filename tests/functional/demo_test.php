<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\tests\functional;

/**
* @group functional
*/
class calendarmonthview_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return ['marttiphpbb/calendarmonthview'];
	}

	public function test_demo_acme()
	{
		$crawler = self::request('GET', 'app.php/demo/acme');
		$this->assertContains('acme', $crawler->filter('h2')->text());

		$this->add_lang_ext('marttiphpbb/calendarmonthview', 'common');
		$this->assertContains($this->lang('DEMO_HELLO', 'marttiphpbb'), $crawler->filter('h2')->text());
		$this->assertNotContains($this->lang('DEMO_GOODBYE', 'marttiphpbb'), $crawler->filter('h2')->text());

		$this->assertNotContainsLang('ACP_DEMO', $crawler->filter('h2')->text());
	}

	public function test_demo_world()
	{
		$crawler = self::request('GET', 'app.php/demo/world');
		$this->assertNotContains('acme', $crawler->filter('h2')->text());
		$this->assertContains('world', $crawler->filter('h2')->text());
	}
}
