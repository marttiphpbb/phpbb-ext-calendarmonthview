<?php
/**
* phpBB Extension - marttiphpbb calendarmonthview
* @copyright (c) 2014 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\calendarmonthview\acp;

use marttiphpbb\calendarmonthview\util\cnst;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $phpbb_container;

		$template = $phpbb_container->get('template');
		$config = $phpbb_container->get('config');
		$request = $phpbb_container->get('request');
		$store = $phpbb_container->get('marttiphpbb.calendarmonthview.store');
		$phpbb_root_path = $phpbb_container->getParameter('core.root_path');

		$language = $phpbb_container->get('language');
		$language->add_lang('acp', cnst::FOLDER);
		add_form_key(cnst::FOLDER);

		switch($mode)
		{
			case 'links':

				$links = $phpbb_container->get('marttiphpbb.calendarmonthview.render.links');

				$this->tpl_name = 'links';
				$this->page_title = $language->lang(cnst::L_ACP . '_LINKS');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key(cnst::FOLDER))
					{
						trigger_error('FORM_INVALID');
					}

					$links->set($request->variable('links', [0 => 0]), $request->variable('calendarmonthview_repo_link', 0));

					trigger_error($language->lang(cnst::L_ACP . '_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$links->assign_acp_select_template_vars();

				break;

			case 'page_rendering':

				$render_settings = $phpbb_container->get('marttiphpbb.calendarmonthview.render.render_settings');

				$this->tpl_name = 'page_rendering';
				$this->page_title = $language->lang(cnst::L_ACP . '_PAGE_RENDERING');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key(cnst::FOLDER))
					{
						trigger_error('FORM_INVALID');
					}

					$render_settings->set($request->variable('render_settings', [0 => 0]));

					$store->transaction_start();
					$store->set_show_isoweek($request->variable('show_isoweek', 0) ? true : false);
					$store->set_first_weekday($request->variable('first_weekday', 0));
					$store->set_min_rows($request->variable('min_rows', 0));
					$store->transaction_end();

					trigger_error($language->lang(cnst::L_ACP . '_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$weekdays = ['Sunday', 'Monday'];

				foreach ($weekdays as $value => $name)
				{
					$template->assign_block_vars('weekdays', [
						'VALUE'			=> $value,
						'S_SELECTED'	=> $config['calendarmonthview_first_weekday'] == $value ? true : false,
						'LANG'			=> $language->lang(['datetime', $name]),
					]);
				}

				$render_settings->assign_acp_template_vars();

				$template->assign_vars([
					'SHOW_ISOWEEK'		=> $store->get_show_isoweek(),
					'FIRST_WEEKDAY'		=> $store->get_first_weekday(),
					'MIN_ROWS'			=> $store->get_min_rows(),
				]);

				break;
		}

		$template->assign_var('U_ACTION', $this->u_action);
	}
}
