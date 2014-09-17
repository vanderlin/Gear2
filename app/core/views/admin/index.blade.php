@extends('slate::admin.layouts.default')

<?php $page = isset($page)?$page:'settings'; ?>

{{-- Web site Title --}}
@section('title')
	{{Config::get('slate::site-name')}} | {{ucfirst($page)}}
@stop

{{-- Content --}}
@section('content')

	@if ($page == 'settings')
		@include('slate::admin.settings')	
	@elseif ($page == 'users')
		@include('slate::admin.users')		
	@elseif ($page == 'roles')
		@include('slate::admin.roles.index')		
	@elseif ($page == 'themes')
		@include('slate::admin.themes')	
	@elseif ($page == 'assets')
		@include('slate::admin.assets')		
	@else 
		@include('slate::admin.settings')
	@endif
	
@stop