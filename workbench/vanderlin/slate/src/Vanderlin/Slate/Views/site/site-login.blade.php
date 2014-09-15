


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
	    		<div class="panel-heading text-center"><h4>Please enter site password</h4></div>
	    		<div class="panel-body text-center">
					
					<div class="row">
						<form class="form col-md-6 col-md-offset-3" id="site-login-form" method="POST" action="{{{ URL::to('/site-login') }}}" accept-charset="UTF-8">
							<div class="form-group">
								<input type="password" class="form-control input-lg" id="site-password" name="site-password" placeholder="">
							</div>

							<div class="form-group">
								<a href="{{ URL::to('email-site-password') }}" class="btn btn-default">Forgot Password</a>
								<button type="submit" class="btn btn-default">Enter</button>
							</div>
						</form>
					</div>
					<div class="row text-center">
						@include('slate::site.partials.form-errors')
					</div>	
				</div>
			</div>
    	</div>
    </div>


    </div>
    <!-- ./ content -->
  
  </body>
</html>




