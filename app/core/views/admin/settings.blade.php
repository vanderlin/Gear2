<h1 class="page-header">Settings</h1>
 
<div class="col-md-6">
	
	<form method="POST" class="form-horizontal" role="form" action="{{{ URL::to('admin/settings') }}}" accept-charset="UTF-8">
		
		<input type="hidden" value="PUT" name="_method">

		<div class="well row">
			<div class="form-group">
				<label for="site-name">Site Name</label>
				<input type="text" class="form-control" id="site-name" name="site-name" placeholder="{{{Config::get('slate::site-name')}}}" value="">
			</div>
		</div>

		<div class="well row">
			<div class="form-group">
				<label for="site-name">Site Password</label>
				<div class="row">
					<div class="col-md-6">
						<input type="text" class="form-control" id="site-password" name="site-password" placeholder="{{{Config::get('slate::site-password')}}}" value="">
					</div>

					<div class="col-md-5 text-center">
						<div class="checkbox">
							<label>
								
								<input {{Config::get('slate::use_site_login')=='1'?'checked':''}}  type="checkbox" name="use-site-password"> Use a site password
							</label>
						</div>
					</div>

				</div>

			</div>
		</div>


		<div class="form-group row">
			<div class="text-right">
				<button type="submit" class="btn btn-default">Update</button>
			</div>
			<a id="test">test</a>
		</div>

	</form>

	<div class="text-center">
		@include('slate::site.partials.form-errors')
	</div>

<pre>
	<?php 
	print_r([Config::get('slate::config.site-name'),
			 Config::getItems()])
	 ?>
</pre>
</div>

<script type="text/javascript">
	$(document).ready(function($) {
		
	
		$("#test").click(function(event) {
			alert("{{ Config::get('slate::site-name') }}");
		});
	});	
</script>