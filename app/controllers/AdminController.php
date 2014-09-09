<?php

class AdminController extends \BaseController {


	// ------------------------------------------------------------------------
	public function updateSettings() {

		if(Input::has('site-name')) {
			$value = Input::get('site-name');
			Config::set('config.site-name', $value);
			ConfigHelper::save('config', 'production');		
		}

		if(Input::has('site-password')) {
			$value = Input::get('site-password');
			Config::set('config.site-password', $value);
			ConfigHelper::save('config', 'production');		
		}
		
		$value = Input::get('use-site-password');
		Session::forget('siteprotection');
		Config::set('config.use_site_login', $value=='on'?true:false);
		ConfigHelper::save('config', 'production');		

		return Redirect::back()->with(['notice'=>'Settings Updated']);

	}

	// ------------------------------------------------------------------------
	public function activateTheme($theme) {

		if(Input::has('activate')) {
			$state = Input::get('activate');
			if($state == 'true') {
				Config::set('config.active-bootstrap-theme', $theme);
			}
			else {
				Config::set('config.active-bootstrap-theme', null);
			}
			ConfigHelper::save('config', 'production');	
		}	

		if(Input::has('install') && Input::get('install')=='true') {
			$is_installed = Theme::where('name', '=', $theme)->get() == NULL;
			if($is_installed) {
				return Redirect::back()->with(['notice'=>'Theme is already installed']);
			}

			$new_theme = new Theme;
			$new_theme->name = $theme;
			$new_theme->path = "assets/theme/{$theme}";
			$new_theme->active = true;
			$new_theme->save();

		}
		

		return Redirect::back()->with(['notice'=>'Bootstrap Theme Updated']);

	}
}