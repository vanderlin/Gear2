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

// ------------------------------------------------------------------------
// Site Password Protection
// ------------------------------------------------------------------------
Route::post('site-login', function() {
	if(Input::has('site-password')) {

		if(Input::get('site-password') == Config::get('config.site-password')) {
			Session::set('siteprotection', 'YES');
			return Redirect::back();
		}
	}
	Session::forget('siteprotection');
	return Redirect::back()->with(['errors'=>'Sorry wrong password']);

});


// ------------------------------------------------------------------------
Route::group(array('before'=>'siteprotection'), function() {

	
	

	/*
	------------------------------------------------------------------------



		********	Start Creating your app routes here		********	 




	------------------------------------------------------------------------
	*/




	// --------------------------------------------------------------------------
	// Admin / Roles
	// --------------------------------------------------------------------------
	Route::group(['prefix'=>'admin', 'before'=>'auth'], function() {
		
		Route::get('/', function() {
			return View::make('admin.index');
		});

		Route::get('users', function() {
			return View::make('admin.index', ['page'=>'users']);
		});

		Route::get('themes', function() {
			return View::make('admin.index', ['page'=>'themes']);
		});

		Route::get('settings', function() {
			return View::make('admin.index', ['page'=>'settings']);
		});

		Route::get('assets', function() {
			return View::make('admin.index', ['page'=>'assets']);
		});

		Route::get('user/{id}', function($id) {
			return View::make('admin.edituser', ['user'=>User::find($id)]);
		});


		Route::resource('roles', 'RolesController');
		Route::resource('permissions', 'PermissionsController');		
		Route::put('user/{id}', ['uses'=>'UsersController@editUserRoles']);
		Route::put('settings', ['uses'=>'AdminController@updateSettings']);
		Route::get('themes/{name}/install', ['uses'=>'AdminController@installTheme']);
		Route::get('themes/{id}', ['uses'=>'AdminController@activateTheme']);
		Route::put('themes/{id}', ['uses'=>'AdminController@updateTheme']);
		Route::get('themes/{id}/edit', ['uses'=>'AdminController@editTheme']);

	});


	// --------------------------------------------------------------------------
	// Assets
	// --------------------------------------------------------------------------	
	Route::group(['prefix'=>'images'], function() {
		Route::get('/', ['uses'=>'AssetsController@index']);
		Route::get('{id}/{size?}', ['uses'=>'AssetsController@resize']);
	});

	// ------------------------------------------------------------------------
	Route::get('assets/upload/modal', function() {
		return View::make('admin.assets.upload-modal');
	});
	Route::get('assets/{id}/edit', function($id) {
		return View::make('admin.assets.edit-modal', ['asset'=>Asset::find($id)]);
	});
	Route::post('assets/upload', ['uses'=>'AssetsController@upload']);
	Route::put('assets/{id}', ['uses'=>'AssetsController@edit']);


	// --------------------------------------------------------------------------
	// Home
	// --------------------------------------------------------------------------	
	Route::get('/', function() {
		return View::make('site.index');
	});

	// --------------------------------------------------------------------------
	// Register | Login
	// --------------------------------------------------------------------------
	Route::get('register', ['uses'=>'UsersController@register']);
	Route::get('login', ['uses'=>'UsersController@login']);
	

	// --------------------------------------------------------------------------
	// Register | Login
	// --------------------------------------------------------------------------
	Route::get('register', ['uses'=>'UsersController@register']);
	Route::get('login', ['uses'=>'UsersController@login']);

	// --------------------------------------------------------------------------
	// Confide routes
	// --------------------------------------------------------------------------
	Route::get('users/create', 'UsersController@create');
	Route::post('users', 'UsersController@store');
	Route::get('users/login', 'UsersController@login');
	Route::post('users/login', 'UsersController@doLogin');
	Route::get('users/confirm/{code}', 'UsersController@confirm');
	Route::get('users/forgot_password', 'UsersController@forgotPassword');
	Route::post('users/forgot_password', 'UsersController@doForgotPassword');
	Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
	Route::post('users/reset_password', 'UsersController@doResetPassword');
	Route::get('users/logout', 'UsersController@logout');
	Route::put('users/{id}', ['uses'=>'UsersController@updateProfile', 'before'=>'auth']);

	// --------------------------------------------------------------------------
	// Profiles & Users
	// --------------------------------------------------------------------------
	Route::group(array('before' => 'auth'), function() {

		Route::get('me', function() {
			return View::make('site.user.profile', ['user'=>Auth::getUser()]);
		});

	});

	// ------------------------------------------------------------------------
	Route::get('users/{id}', ['uses'=>'UsersController@show']);





});


