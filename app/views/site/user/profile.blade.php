@extends('site.layouts.default')

{{-- Title --}}
@section('title')
	{{ Config::get('config.site-name') }} | {{ $user->getName() }}
@stop


{{-- Scripts --}}
@section('scripts')
    
@stop


{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		

		{{-- -------------------------------------------------------- --}}
		@if (Auth::check() && Auth::id() == $user->id)
			
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
								<div class="col-sm-12">
									<img src="{{ $user->profileImage->url() }}" class="img-circle profile-image"> 
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
								@include('site.partials.form-errors')
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
							
						<div class="col-md-12">
							<div class="list-group">
								@foreach ($user->experiences as $experience)
									<div class="list-group-item">
										{{ link_to('experiences/'.$experience->id, $experience->title, ['class'=>'']) }}
										@if ($experience->hasLocation())
											<small class="pull-right"> {{ $experience->location->name }}</small>
										@endif
									</div>
								@endforeach
							</div>

						</div>

					</div>
				</div>
			</div>
			{{-- -------------------------------------------------------- --}}

		@endif

	</div>
</div>
@stop
