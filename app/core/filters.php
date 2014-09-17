<?php 

// ------------------------------------------------------------------------
Route::filter('siteprotection', function() {
	if(Config::get('slate::use_site_login') && Session::has('siteprotection') == false) {
		return View::make('slate::site.site-login');
	}
});