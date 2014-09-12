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


Route::get('/', function() {
	
	$t = Config::get('slate::site-name');
	Config::set('slate::site-name', '123');
	Config::save();

	return [$t, Config::get('slate::site-name')];

});