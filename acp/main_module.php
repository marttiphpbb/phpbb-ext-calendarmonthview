<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $template, $request;
		global $config, $phpbb_root_path;
		global $phpbb_container;

		$language = $phpbb_container->get('language');
		$language->add_lang('acp', 'marttiphpbb/calendarmonthview');
		add_form_key('marttiphpbb/calendarmonthview');

		switch($mode)
		{
			case 'links':

				$links = $phpbb_container->get('marttiphpbb.calendarmonthview.render.links');

				$this->tpl_name = 'links';
				$this->page_title = $language->lang('ACP_CALENDARMONTHVIEW_LINKS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/calendarmonthview'))
					{
						trigger_error('FORM_INVALID');
					}

					$links->set($request->variable('links', [0 => 0]), $request->variable('calendarmonthview_repo_link', 0));

					trigger_error($language->lang('ACP_CALENDARMONTHVIEW_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$links->assign_acp_select_template_vars();

				break;

			case 'page_rendering':

				$render_settings = $phpbb_container->get('marttiphpbb.calendarmonthview.render.render_settings');

				$this->tpl_name = 'page_rendering';
				$this->page_title = $language->lang('ACP_CALENDARMONTHVIEW_PAGE_RENDERING');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/calendarmonthview'))
					{
						trigger_error('FORM_INVALID');
					}

					$render_settings->set($request->variable('render_settings', [0 => 0]));
					$config->set('calendarmonthview_first_weekday', $request->variable('calendarmonthview_first_weekday', 0));
					$config->set('calendarmonthview_min_rows', $request->variable('calendarmonthview_min_rows', 5));

					trigger_error($language->lang('ACP_CALENDARMONTHVIEW_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

				foreach ($weekdays as $value => $name)
				{
					$template->assign_block_vars('weekdays', [
						'VALUE'			=> $value,
						'S_SELECTED'	=> $config['calendarmonthview_first_weekday'] == $value ? true : false,
						'LANG'			=> $language->lang(['datetime', $name]),
					]);
				}

				$render_settings->assign_acp_template_vars();

				$template->assign_var('CALENDARMONTHVIEW_MIN_ROWS', $config['calendarmonthview_min_rows']);

				break;
		}

		$template->assign_var('U_ACTION', $this->u_action);
	}
}
