<?php
	

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



// --------------------------------------------------------------------------
// Example how to override the core routes - ie: Home
// --------------------------------------------------------------------------	
Route::get('/', function() {
	if(Auth::check()) {
		return View::make('slate::site.user.profile', ['user'=>Auth::user()]);
	}
	return View::make('slate::site.user.login');
});
