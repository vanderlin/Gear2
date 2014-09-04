@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{ Config::get('config.site_name') }} | Travlers
@stop

@section('scripts')
   
@stop


{{-- Content --}}
@section('content')



<div class="row">
	<div class="col-md-8 col-md-offset-2">


		
			<div class="panel panel-default">
				<div class="panel-heading" id="experience-title"><h3 class="text-center">Travelers</h3></div>
			
				<div class="panel-body">
					@foreach (User::all() as $user)			

						<div class="row">
							
							<div class="col-md-1">
								<img src="{{ $user->profileImage->url('w50') }}" class="img-circle">
							</div>
							
							<div class="col-md-11">
								<ul class="list-unstyled">
									<li><h4>{{ link_to($user->profileLink, $user->getName()) }}</h4></li>
									<li><smal class="text-muted"></small></li>
									<li>{{ $user->location->name }} | {{$user->roles()->first()->name}}</li>
								</ul>
							</div>

						</div>
						<br>


					@endforeach
				</div>

			</div>
		


	</div>
</div>
@stop
