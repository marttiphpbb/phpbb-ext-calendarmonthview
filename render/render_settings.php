<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\render;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\language\language;

class render_settings
{
	protected $config;
	protected $template;
	protected $language;

	protected $render_settings = [
		1		=> 'ISOWEEK',
		2		=> 'MOONPHASE',
		4		=> 'TODAY',
	];

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
		$render_settings = $this->config['calendarmonthview_render_settings'];
		$template_vars = [];

		foreach ($this->render_settings as $key => $value)
		{
			if ($key & $render_settings)
			{
				$template_vars['S_' . $value] = true;
			}
		}

		$this->template->assign_vars($template_vars);
		return $this;
	}

	public function assign_acp_template_vars():self
	{
		$render_settings = $this->config['calendarmonthview_render_settings'];

		foreach ($this->render_settings as $key => $value)
		{
			$explain_key = 'ACP_CALENDARMONTHVIEW_' . $value . '_EXPLAIN';
			$explain = isset($this->language->lang[$explain_key]) ? $this->language->lang[$explain_key] : '';

			$this->template->assign_block_vars('render_settings', [
				'VALUE'			=> $key,
				'S_CHECKED'		=> ($key & $render_settings) ? true : false,
				'LABEL'			=> $this->language->lang('ACP_CALENDARMONTHVIEW_' . $value),
				'EXPLAIN'		=> $explain,
			]);
		}

		return $this;
	}

	public function set(array $render_settings):self
	{
		$this->config->set('calendarmonthview_render_settings', array_sum($render_settings));
		return $this;
	}
}
