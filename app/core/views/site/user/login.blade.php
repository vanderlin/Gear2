


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
				@include('slate::site.user.login-form')
			</div>

		</div>

		
	    <div id="form-information" class="text-center">
	    	@include('slate::site.partials.form-errors')
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
					url: '{{ URL::to("google/signin") }}?state={{core\controllers\GoogleSessionController::getState()}}',
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






























