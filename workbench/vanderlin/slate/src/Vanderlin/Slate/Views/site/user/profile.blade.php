@extends('slate::site.layouts.default')

{{-- Title --}}
@section('title')
	{{ Config::get('slate::site-name') }} | {{ $user->getName() }}
@stop


{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript">
    $(document).ready(function() {
    	
    	// $("#profile-image-container").click(function() {

    	// });
    	//hover({
    	// 	over:function() {
    	// 	},
    	// 	out:function() {
    	// 	}
    	// });

    });
    </script>
@stop


{{-- Content --}}
@section('content')

<!-- Modal -->
<div class="modal fade" id="asset-upload-modal" tabindex="-1" role="dialog" aria-labelledby="asset-upload" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div>
  </div>
</div>
<!-- Modal -->

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		

		{{-- -------------------------------------------------------- --}}
		@if ( (Auth::check() && Auth::id() == $user->id) || (Auth::user()->hasRole('Admin')))
			
			{{-- Profile info --}}
			<div class="panel panel-default">
				
				<div class="panel-heading">
					<div class="row">
						<h4 class="col-md-6">{{ $user->getName() }}</h4>
						@if (count($user->roles) > 0)
							@if ($user->hasRole('Admin'))
							<h5 class="col-md-6 text-right text-muted">{{link_to('admin', $user->getRoleName())}}</h5> 	
							@else
							<h5 class="col-md-6 text-right text-muted">{{$user->getRoleName()}}</h5> 	
							@endif
						@endif
					</div>
				</div>

				<div class="panel-body">
					<form method="POST" class="form-horizontal" role="form" action="{{{ URL::to('users/'.$user->id) }}}" accept-charset="UTF-8">
	      				<fieldset>
		      				<input type="hidden" value="PUT" name="_method">
		      				
		      				<div class="form-group text-center">
								<div class="col-sm-12" id="profile-image-container">
									<img src="{{ $user->profileImage->url('s150') }}" class="img-circle profile-image"> 
									<div class="edit-profile-image-button">
										<?php $type = get_class($user); ?>
										@if ($user->hasDefaultProfileImage())
											{{ link_to("assets/upload/modal?id={$user->id}&type={$type}", 'Upload Image', ['data-toggle'=>'modal', 'data-target'=>'#asset-upload-modal']) }}
										@else
											{{ link_to("assets/{$user->profileImage->id}/edit?modal=true", 'Edit', ['data-toggle'=>'modal', 'data-target'=>'#asset-upload-modal']) }}
										@endif
									</div>
								</div>
							</div>
							
		  					<div class="form-group">
				          		<label for="username" class="col-sm-3 control-label">Username</label>
					          	<div class="col-sm-9">
					            	<input type="text" class="form-control" id="username" placeholder="Username" value="{{$user->username}}" disabled>
					          	</div>
				        	</div>

				        	<div class="form-group">
				          		<label for="email" class="col-sm-3 control-label">Email</label>
				          		<div class="col-sm-9">
				            		<input type="email" class="form-control" id="email" name="email" placeholder="example@website.com" value="{{$user->email}}" {{Auth::user()->hasRole('Admin')?'':'disabled'}}>
				          		</div>
				        	</div>

				        	

				        	<div class="form-group">
								<label for="firstname" class="col-sm-3 control-label">First Name</label>
				          		<div class="col-sm-9">
					            	<input class="form-control" placeholder="First Name" type="text" name="firstname" id="firstname" value="{{$user->firstname}}">
					        	</div>
					        </div>

					        <div class="form-group">
								<label for="lastname" class="col-sm-3 control-label">Last Name</label>
				          		<div class="col-sm-9">
					            	<input class="form-control" placeholder="Last Name" type="text" name="lastname" id="lastname" value="{{$user->lastname}}">
					        	</div>
					        </div>

				        	<div class="form-group">
								<label for="password" class="col-sm-3 control-label">Password</label>
				          		<div class="col-sm-9">
					            	<input class="form-control" placeholder="Change Password" type="password" name="password" id="password">
					        	</div>
					        </div>
					        <div class="form-group">
					            <label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
					            <div class="col-sm-9">
					            	<input class="form-control" placeholder="Confirm Password" type="password" name="password_confirmation" id="password_confirmation">
					        	</div>
					        </div>
				      
							<div class="form-group row">
				        		<div class="col-md-12 text-right">
				          			<button type="submit" class="btn btn-default">Update</button>
				        		</div>
				      		</div>

				      		<div class="form-group row text-center">
								@include('slate::site.partials.form-errors')
				      		<div>

						</fieldset>
				    </form>
				</div>
			</div>
		@else 
		{{-- -------------------------------------------------------- --}}


			{{-- -------------------------------------------------------- --}}
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<h4 class="col-md-6">{{ $user->getName() }}</h4>
						@if (count($user->roles) > 0)
							<h5 class="col-md-6 text-right text-muted">{{$user->getRoleName()}}</h5> 	
						@endif
					</div>
				</div>
				<div class="panel-body">
	  				<div class="form-group">
						
						<div class="col-sm-12 text-center">
							<img src="{{ $user->profileImage->url() }}" class="img-circle profile-image"> 
							<br><br>
						</div>
							
					

					</div>
				</div>
			</div>
			{{-- -------------------------------------------------------- --}}

		@endif

	</div>
</div>
@stop
