


@extends('slate::site.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{Config::get('slate::site-name')}} | Login
@stop




{{-- Head --}}
@section('head')
@stop



{{-- Content --}}
@section('content')

	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6"><h4>Login</h4></div>
					<div class="col-md-6 text-right"><h6>{{ link_to('/register', 'Register', ['type'=>'submit', 'class'=>'']) }}</h6></div>
				</div>
			</div>
			
			<div class="panel-body">
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
					            @if (Config::get('config.use_google_login'))
					            	<div class="col-md-9 pull-left" style="margin-top:2px">
										<a href="{{ GoogleSessionController::generateOAuthLink(['access_type'=>'offline', 'hd'=>'ideo.com', 'registering'=>true, 'display'=>'popup', 'state'=>'signin']) }}" class="btn btn-default">Sign in with google</a>
									</div>
								@endif
							</div>

				        </div>
				    </fieldset>
				</form>

				<div class="text-center">
				</div>

		        <div id="form-information" class="text-center">
		        	@include('slate::site.partials.form-errors')
				</div>

			</div>
		</div>
	</div>

@stop


{{-- Script --}}
@section('scripts')
	
	@include('slate::site.partials.google-js')

	<script type="text/javascript">
	var helper = (function() {
  		var authResult = undefined;

  		return {
			
			// ------------------------------------------------------------------------
			onSignInCallback: function(authResult) {
				if (authResult['access_token']) {
					this.authResult = authResult;
					helper.connectServer();
				}
				else if (authResult['error']) {
				
				}
		      	console.log('authResult', authResult);
		    },
		    
		    // ------------------------------------------------------------------------
			connectServer: function() {	
				$.ajax({
					url: '{{ URL::to("google/signin") }}?state={{Vanderlin\Slate\Controllers\GoogleSessionController::getState()}}',
					type: 'POST',
					dataType: 'json',
        			data: {'code':this.authResult.code},
					success: function(result) {
						if(result.errors) {
							var errorsString = '';
							for (var i = 0; i < result.errors.length; i++) {
								errorsString += result.errors[i]+"<br>";
							};
							$("#form-information").html(errorsString);
						}
						
						if(result.back_url) {
							$("#form-information").html(result.notice);
							document.location = result.back_url;
						}

						console.log(result);
					}
				});
			},
			// ------------------------------------------------------------------------
		}

	})();

	// ------------------------------------------------------------------------
	function onSignInCallback(authResult) {
  		helper.onSignInCallback(authResult);
	}
	</script>
@stop






























