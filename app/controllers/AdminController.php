<?php

class AdminController extends \BaseController {


	// ------------------------------------------------------------------------
	public function updateSettings() {

		if(Input::has('site-name')) {
			$sitename = Input::get('site-name');
			Config::set('config.site-name', $sitename);
			ConfigHelper::save('config', 'production');		
		}

		return Redirect::back()->with(['notice'=>'Settings Updated']);

	}

}