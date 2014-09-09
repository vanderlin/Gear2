<h1 class="page-header">Settings</h1>
 
<div class="col-md-6">
	
	<form method="POST" class="form-horizontal" role="form" action="{{{ URL::to('admin/settings') }}}" accept-charset="UTF-8">
		<input type="hidden" value="PUT" name="_method">

		<div class="well row">
			<div class="form-group">
				<label for="site-name">Site Name</label>
				<input type="text" class="form-control" id="site-name" name="site-name" placeholder="{{{Config::get('config.site-name')}}}" value="">
			</div>
		</div>

		<div class="form-group row">
			<div class="text-right">
				<button type="submit" class="btn btn-default">Update</button>
			</div>
		</div>

		<div class="text-center">
			@include('site.partials.form-errors')
		</div

	</form>

</div>