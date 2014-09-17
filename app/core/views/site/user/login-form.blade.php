<form method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.username_e_mail') }}}</label>
            <input class="form-control" tabindex="1" placeholder="Enter email" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
        <label for="password">
            {{{ Lang::get('confide::confide.password') }}}
            <small>
                <a href="{{{ URL::to('/users/forgot_password') }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a>
            </small>
        </label>
        <input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="checkbox">
            <label for="remember" class="checkbox">
                <input type="hidden" name="remember" value="0">
                <input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
                {{{ Lang::get('confide::confide.login.remember') }}}
            </label>
        </div>
        
        <div class="form-group">
        	
        	<div class="row">
	        	<div class="col-md-3">
	            	<button tabindex="3" type="submit" class="btn btn-default">{{{ Lang::get('confide::confide.login.submit') }}}</button>
	            </div>
	            @if (Config::get('slate::use_google_login'))
	            	<div class="col-md-9 pull-left" style="margin-top:2px">
						<a href="{{ Vanderlin\Slate\Controllers\GoogleSessionController::generateOAuthLink(['access_type'=>'offline', 'hd'=>'ideo.com', 'registering'=>true, 'display'=>'popup', 'state'=>'signin']) }}" class="btn btn-default">Sign in with google</a>
					</div>
				@endif
			</div>

        </div>
    </fieldset>
</form>