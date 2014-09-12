<?php namespace Vanderlin\Slate\Controllers;

use Input;
use Config;
use Vanderlin\Slate\Helpers\ConfigHelper;
use Illuminate\Support\Facades\Session;
use Controller;
use Illuminate\Support\Facades\Redirect;

class AdminController extends \BaseController {


	// ------------------------------------------------------------------------
	public function updateSettings() {





		if(Input::has('site-name')) {
			$value = Input::get('site-name');
			Config::set('slate::site-name', $value);
			ConfigHelper::save('slate::site-name', 'production');		
		}
		dd(Input::all());

		if(Input::has('site-password')) {
			$value = Input::get('site-password');
			Config::set('config.site-password', $value);
			ConfigHelper::save('config', 'production');		
		}
		
		$value = Input::get('use-site-password');
		Session::forget('siteprotection');
		Config::set('slate::use_site_login', $value=='on'?true:false);
		ConfigHelper::save('slate::config', 'production');		

		return Redirect::back()->with(['notice'=>'Settings Updated']);

	}

	// ------------------------------------------------------------------------
	public function updateTheme($id) {
		$theme = Theme::find($id);
		if($theme && Input::has('code')) {

			$theme->code = urlencode(Input::get('code'));
			$theme->save();

			return Redirect::back()->with(['notice'=>'Theme Updated']);
		}
		return Redirect::back()->with(['notice'=>'No Theme Found']);
	}

	// ------------------------------------------------------------------------
	public function installTheme($name) {

		$is_installed = Theme::where('name', '=', $name)->get() == NULL;
		if($is_installed) {
			return Redirect::back()->with(['notice'=>'Theme is already installed']);
		}

		$theme = new Theme;
		$theme->name = $name;
		$theme->path = "assets/themes/{$name}";
		$theme->active = false;
		$theme->save();



		return Redirect::back()->with(['notice'=>'Bootstrap Theme Updated']);

	}
	// ------------------------------------------------------------------------
	public function activateTheme($id) {

		$theme = Theme::find($id);
		if($theme == NULL) return Redirect::back()->with(['notice'=>'No Theme Found']);

		if(Input::has('activate')) {
			foreach (Theme::all() as $t) {
				if($t->active == true) {
					$t->active = false;
					$t->save();
				}
			}
			$state = Input::get('activate');
			$theme->active = $state == 'true' ? true : false;
			$theme->save();
		}	

		return Redirect::back()->with(['notice'=>'Bootstrap Theme Updated']);
	}

	// ------------------------------------------------------------------------
	public function editTheme($id) {

		return View::make('slate::admin.themes-modal', ['theme'=>Theme::find($id)]);
	}

}