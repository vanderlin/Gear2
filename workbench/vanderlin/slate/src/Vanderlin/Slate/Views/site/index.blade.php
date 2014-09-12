@extends('slate::site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{Config::get('slate::site-name')}} | Register
@stop

{{-- Content --}}
@section('content')

@if (Auth::check())
	<h3 class="text-center">Hi {{ ucwords(Auth::user()->getName()) }}</h3>
@else
	<div class="col-md-6 col-md-offset-3">
		<div class="row">
			<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h3>Welcome to {{ Config::get('config.site-name') }}</h3>
			</div>
			<div class="panel-body text-center">
				<br><br><br>	
				{{link_to('/login', 'Login', ['class'=>'btn btn-default'])}}  {{link_to('/register', 'Register', ['class'=>'btn btn-default'])}}
				<br><br><br>
			</div>	
			</div>
		</div>
	</div>
@endif



@stop
