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

	

	// --------------------------------------------------------------------------
	// Admin / Roles
	// --------------------------------------------------------------------------
	Route::group(['prefix'=>'admin', 'before'=>'auth'], function() {
		
		Route::get('/', function() {
			return View::make('admin.index');
		});

		Route::get('users', function() {
			return View::make('admin.index');
		});

		Route::get('user/{id}', function($id) {
			return View::make('admin.edituser', ['user'=>User::find($id)]);
		});


		Route::resource('roles', 'RolesController');
		Route::resource('permissions', 'PermissionsController');		
		Route::put('user/{id}', ['uses'=>'UsersController@editUserRoles']);

	});


	// --------------------------------------------------------------------------
	// Assets
	// --------------------------------------------------------------------------	
	Route::group(['prefix'=>'images'], function() {
		Route::get('/', ['uses'=>'AssetsController@index']);
		Route::get('{id}/{size?}', ['uses'=>'AssetsController@resize']);
	});



	// --------------------------------------------------------------------------
	// Home
	// --------------------------------------------------------------------------	
	Route::get('/', function() {

		$file = 'local/database';
		$phppos = strrpos($file, ".php");
		return substr($file, 0, $phppos?$phppos:strlen($file));
		
		$reader = Config::getLoader();//new ConfigHelper(Config::getLoader()->getFilesystem(), Config::getEnvironment());
	 	$data = $reader->load('local', 'local/database');


	 	$data2 = $data;
	 	array_set($data2, 'connections.mysql.username', '***');

	 	//            $data = "<?php return ".var_export( $items, true).";";


		return ['A'=>$data, 'B'=>$data2];

		return DB::connection()->getConfig('username');
		return '';
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
	// Experiences
	// --------------------------------------------------------------------------
	Route::group(array('before' => 'auth'), function() {

		Route::get('me', function() {
			return View::make('site.user.profile', ['user'=>Auth::getUser()]);
		});

	});


});


