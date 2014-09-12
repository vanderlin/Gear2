<?php namespace Vanderlin\Slate\Controllers;

use Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;


use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideUser;

/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller {

    // ------------------------------------------------------------------------
    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create() {
        return View::make('slate::site.user.register');
    }

    // ------------------------------------------------------------------------
    public function show($id) {
        return View::make('slate::site.user.profile', ['user'=>User::find($id)]);
    }

    // ------------------------------------------------------------------------
    public function register() {
        return View::make('slate::site.user.register');
    }

    // ------------------------------------------------------------------------
    public function editUserRoles($id) {

        $user = User::findOrFail($id);
        if($user) {

            $rolesToAttach = [];
            foreach (Input::get('roles') as $key => $value) {
                $role = Role::where('id', '=', $key)->first();
                if($role) {
                    array_push($rolesToAttach, $key);
                }
            }

            if(count($rolesToAttach) > 0) {
                $user->roles()->sync($rolesToAttach);
            }

            return Redirect::back()->with('notice', 'User updated');
        }

        return Redirect::back()->with('error', 'Could not find user');
    }

    // ------------------------------------------------------------------------
    public function updateProfile($id) {

        $user = User::find($id);
        if($user) {

            $made_update = false;
            // password
            if( Input::has('password') && Input::has('password_confirmation')) {
                $input = ['password'=>Input::get('password'),
                          'password_confirmation'=>Input::get('password_confirmation')];

                $user->password = $input['password'];
                $user->password_confirmation = $input['password_confirmation'];                        

                $made_update = true;
            }


            if (Input::has('firstname') || Input::has('lastname')) {
                $user->firstname = Input::get('firstname');
                $user->lastname = Input::get('lastname');
                $made_update = true;
            }


            if (Input::has('email')) {
                $user->email = Input::get('email');
                $made_update = true;
            }


            if(Input::has('office_location')) {
                $user->location_id = Input::get('office_location');
                $made_update = true;
            }

            // did we make an update
            if ($made_update) {
                
                
                if($user->save()) {
                    return Redirect::back()->with(['notice'=>'Profile updated']);
                }

                return Redirect::back()->with(['errors'=>$user->errors()->all()]);
            }




            return Redirect::back()->with(['errors'=>'Nothing to update']);


        }
        return Redirect::back()->with(['errors'=>'No User found']);

    }


    // ------------------------------------------------------------------------
    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store() {

        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id) {
            
            $role = $role = Role::where('name', '=', 'Writer')->first();
            $user->attachRole($role);

            Auth::login($user);

            return Redirect::action('UsersController@login')->with('notice', Lang::get('confide::confide.alerts.account_created'));

            Mail::queueOn(
                Config::get('confide::email_queue'),
                Config::get('confide::email_account_confirmation'),
                compact('user'),
                function ($message) use ($user) {
                    $message
                        ->to($user->email, $user->username)
                        ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                }
            );

            //Redirect::action('UsersController@login')
                //->with('notice', Lang::get('confide::confide.alerts.account_created'));
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::action('UsersController@create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }
    }

    // ------------------------------------------------------------------------
    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login() {
        if (\Confide::user()) {
            return Redirect::to('/');
        } else {
        	return View::make('slate::site.user.login');
        }
    }


    // ------------------------------------------------------------------------
    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin() {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::intended('/');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    // ------------------------------------------------------------------------
    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@doForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@reset_password', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }
}
