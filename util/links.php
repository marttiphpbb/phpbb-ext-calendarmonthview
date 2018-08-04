<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\util;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\language\language;

class links
{
	protected $config;
	protected $template;
	protected $language;

	public function __construct(
		config $config,
		template $template,
		language $language
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->language = $language;
	}

	public function assign_template_vars():self
	{
		$links_enabled = $this->config['calendarmonthview_links'];
		$template_vars = [];

		foreach ($this->links as $key => $value)
		{
			if ($key & $links_enabled)
			{
				$template_vars['S_MARTTIPHPBB_CALENDARMONTHVIEW_' . $value] = true;
			}
		}

		$this->template->assign_vars($template_vars);
		return $this;
	}

	public function assign_acp_select_template_vars():self
	{
		$links_enabled = $this->config['calendarmonthview_links'];

		$this->template->assign_var('S_MARTTIPHPBB_CALENDARMONTHVIEW_REPO_LINK', $links_enabled & 1 ? true : false);

		$links = $this->links;

		unset($links[1]);

		foreach ($links as $key => $value)
		{
			$this->template->assign_block_vars('links', [
				'VALUE'			=> $key,
				'S_SELECTED'	=> ($key & $links_enabled) ? true : false,
				'LANG'			=> $this->language->lang('ACP_MARTTIPHPBB_CALENDARMONTHVIEW_' . $value),
			]);
		}
		return $this;
	}

	public function set(array $links, int $calendarmonthview_repo_link):self
	{
		$this->config->set('calendarmonthview_links', array_sum($links) + $calendarmonthview_repo_link);
		return $this;
	}
}
