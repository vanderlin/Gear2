
{{-- Web site Title --}}
@section('title')
{{Config::get('slate::site-name')}} | Forgot Password
@stop

<!DOCTYPE html>
<html lang="en">
  <head>
    @include('slate::site.layouts.head')
  </head>
  <body>

    <!-- Content -->
    <div class="container main-content">
      

    <div class="row">
    	<div class="col-md-6 col-md-offset-3">
	    	<div class="panel panel-default">
	    		<div class="panel-heading text-center"><h4>Forgot site password?</h4></div>
	    		<div class="panel-body text-center">
					
					<div class="row">
						<form class="form col-md-6 col-md-offset-3" id="site-login-form" method="POST" action="{{{ URL::to('/email-site-password') }}}" accept-charset="UTF-8">
							<div class="form-group">
								<input type="email" class="form-control input-lg" id="site-password" name="email" placeholder="enter your email">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-default">Email Password</button>
								<a href="{{URL::to('')}}" class="btn btn-default">Login</a>
							</div>
						</form>
					</div>
					
				</div>
			</div>

			<div class="text-center">
				@include('slate::site.partials.form-errors')
			</div>	
    	</div>
    </div>


    </div>
    <!-- ./ content -->
  
  </body>
</html>




