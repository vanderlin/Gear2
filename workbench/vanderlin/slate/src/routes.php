<?php


require __DIR__.'/filters.php';


// ------------------------------------------------------------------------
// Site Password Protection
// ------------------------------------------------------------------------
Route::post('site-login', function() {
	if(Input::has('site-password')) {

		if(Input::get('site-password') == Config::get('slate::site-password')) {
			Session::set('siteprotection', 'YES');
			return Redirect::back();
		}
	}
	Session::forget('siteprotection');
	return Redirect::back()->with(['errors'=>'Sorry wrong password']);

});

Route::get('email-site-password', function() {
	return View::make("slate::site.email-site-password");
});

Route::post('email-site-password', function() {
	if(Input::has('email')) {

		$email = Input::get('email');

		if(User::where('email', '=', $email)->first()) {

			Mail::send('slate::emails.test', array('key' => 'value'), function($message) use($email) {
			    $message->to($email, Config::get('slate::site-name'))->subject('Site Password');
			});
			return Redirect::back()->with(['notice'=>"An email was sent to {$email}"]);
		}
		return Redirect::back()->with(['error'=>'No user found by that email']);
	}
	return Redirect::back()->with(['error'=>'Missing email']);
});



// ------------------------------------------------------------------------
Route::group(array('before'=>'siteprotection'), function() {

	

	// --------------------------------------------------------------------------
	// Admin / Roles
	// --------------------------------------------------------------------------
	Route::group(['prefix'=>'admin', 'before'=>'auth'], function() {
		
		Route::get('/', function() {
			return View::make('slate::admin.index');
		});

		Route::get('users', function() {
			return View::make('slate::admin.index', ['page'=>'users']);
		});

		Route::get('themes', function() {
			return View::make('slate::admin.index', ['page'=>'themes']);
		});

		Route::get('settings', function() {
			return View::make('slate::admin.index', ['page'=>'settings']);
		});

		Route::get('assets', function() {
			return View::make('slate::admin.index', ['page'=>'assets']);
		});

		Route::get('user/{id}', function($id) {
			return View::make('slate::admin.edituser', ['user'=>User::find($id)]);
		});


		Route::resource('roles', 'Vanderlin\Slate\Controllers\RolesController');
		Route::resource('permissions', 'Vanderlin\Slate\Controllers\PermissionsController');		
		Route::put('user/{id}', ['uses'=>'Vanderlin\Slate\Controllers\UsersController@editUserRoles']);
		Route::put('settings', ['uses'=>'Vanderlin\Slate\Controllers\AdminController@updateSettings']);
		Route::get('themes/{name}/install', ['uses'=>'Vanderlin\Slate\Controllers\AdminController@installTheme']);
		Route::get('themes/{id}', ['uses'=>'Vanderlin\Slate\Controllers\AdminController@activateTheme']);
		Route::put('themes/{id}', ['uses'=>'Vanderlin\Slate\Controllers\AdminController@updateTheme']);
		Route::get('themes/{id}/edit', ['uses'=>'Vanderlin\Slate\Controllers\AdminController@editTheme']);

	});


	// --------------------------------------------------------------------------
	// Assets
	// --------------------------------------------------------------------------	
	Route::group(['prefix'=>'images'], function() {
		Route::get('/', ['uses'=>'Vanderlin\Slate\Controllers\AssetsController@index']);
		Route::get('{id}/{size?}', ['uses'=>'Vanderlin\Slate\Controllers\AssetsController@resize']);
	});

	// ------------------------------------------------------------------------
	Route::get('assets/upload/modal', function() {
		return View::make('slate::admin.assets.upload-modal');
	});
	Route::get('assets/{id}/edit', function($id) {
		return View::make('slate::admin.assets.edit-modal', ['asset'=>Asset::find($id)]);
	});
	Route::post('assets/upload', ['uses'=>'Vanderlin\Slate\Controllers\AssetsController@upload']);
	Route::put('assets/{id}', ['uses'=>'Vanderlin\Slate\Controllers\AssetsController@edit']);


	// --------------------------------------------------------------------------
	// Home
	// --------------------------------------------------------------------------	
	Route::get('/', function() {
		return View::make('slate::site.index');
	});

	// --------------------------------------------------------------------------
	// Register | Login
	// --------------------------------------------------------------------------
	Route::get('register', ['uses'=>'Vanderlin\Slate\Controllers\UsersController@register']);
	Route::get('login', ['uses'=>'Vanderlin\Slate\Controllers\UsersController@login']);

	// --------------------------------------------------------------------------
	// Confide routes
	// --------------------------------------------------------------------------
	Route::get('users/create', 'Vanderlin\Slate\Controllers\UsersController@create');
	Route::post('users', 'Vanderlin\Slate\Controllers\UsersController@store');
	Route::get('users/login', 'Vanderlin\Slate\Controllers\UsersController@login');
	Route::post('users/login', 'Vanderlin\Slate\Controllers\UsersController@doLogin');
	Route::get('users/confirm/{code}', 'Vanderlin\Slate\Controllers\UsersController@confirm');
	Route::get('users/forgot_password', 'Vanderlin\Slate\Controllers\UsersController@forgotPassword');
	Route::post('users/forgot_password', 'Vanderlin\Slate\Controllers\UsersController@doForgotPassword');
	Route::get('users/reset_password/{token}', 'Vanderlin\Slate\Controllers\UsersController@resetPassword');
	Route::post('users/reset_password', 'Vanderlin\Slate\Controllers\UsersController@doResetPassword');
	Route::get('users/logout', 'Vanderlin\Slate\Controllers\UsersController@logout');
	Route::put('users/{id}', ['uses'=>'Vanderlin\Slate\Controllers\UsersController@updateProfile', 'before'=>'auth']);

	// --------------------------------------------------------------------------
	// Profiles & Users
	// --------------------------------------------------------------------------
	Route::group(array('before' => 'auth'), function() {

		Route::get('me', function() {
			return View::make('slate::site.user.profile', ['user'=>Auth::getUser()]);
		});

	});

	// ------------------------------------------------------------------------
	Route::get('users/{id}', ['uses'=>'Vanderlin\Slate\Controllers\UsersController@show']);





});
