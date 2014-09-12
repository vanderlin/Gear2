<?php $session_errors = Session::get('errors') ?>
@if ($session_errors)
	@if (is_array($session_errors))
		@foreach ($session_errors as $er)
			{{ $er }}<br>
		@endforeach
	@else
		<div class="alert" id="session-errors">{{{ Session::get('errors') }}}</div>
	@endif
@endif
@if (Session::has('error')) 
    <div class="alert">{{{ Session::get('error') }}}</div>	
@endif
@if (Session::get('notice'))
    <div class="alert">{{{ Session::get('notice') }}}</div>
@endif