@extends('slate::site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{Config::get('slate::site-name')}} | Register
@stop

@section('head')
	{{--@include('slate::site.partials.google-meta')--}}
@stop

{{-- -------------------------------------------------------------- --}}
{{-- 						    Script 								--}}
{{-- -------------------------------------------------------------- --}}
@section('scripts')
	
	@include('slate::site.partials.google-js')

	<script type="text/javascript">
	var win = null;
	$("#google-register-btn").click(function() {
		var w = 430;
		var h = 650;
		var title = 'Register With Google';
		var left = (screen.width/2)-(w/2);
  		var top  = (screen.height/2)-(h/2);
  		var url  = "{{ Vanderlin\Slate\Controllers\GoogleSessionController::generateOAuthLink(['hd'=>'ideo.com']) }}";

  		if(win) win.close();
  		win = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);

	});

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
					url: '{{ URL::to("google/register") }}?state={{Vanderlin\Slate\Controllers\GoogleSessionController::getState()}}',
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



{{-- -------------------------------------------------------------- --}}
{{-- 						   Content 	     						--}}
{{-- -------------------------------------------------------------- --}}
@section('content')

<div class="col-md-4 col-md-offset-4">
	<div class="panel panel-default">

		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6"><h4>Register</h4></div>
				<div class="col-md-6 text-right"><h6>{{ link_to('/login', 'Login', ['type'=>'submit', 'class'=>'']) }}</h6></div>
			</div>
		</div>

		<div class="panel-body">
			@include('slate::site.user.register-form')
			{{-- Confide::makeSignupForm()->render() --}}
		</div>
	</div>

    @if (Config::get('slate::use_google_login'))
	<div class="panel panel-default">
		<div class="panel-heading"><h4>Register via Google+</h4></div>
		<div class="panel-body text-center">

			{{-- GoogleSessionController::generateGoogleLoginButton(['data-width'=>'wide']); --}}
			<a href="{{ Vanderlin\Slate\Controllers\GoogleSessionController::generateOAuthLink(['access_type'=>'offline', 'hd'=>'ideo.com', 'registering'=>true, 'display'=>'popup', 'state'=>'registering']) }}" class="btn btn-default">Register with google</a>
			<!-- <a href="#register" id="google-register-btn" class="btn btn-default">Register with google</a> -->
			<div class="error-text" id="form-information"></div>
		</div>
	</div>
	@endif
	
	<div id="form-information" class="text-center">
    	@include('slate::site.partials.form-errors')
	</div>

</div>
@stop
