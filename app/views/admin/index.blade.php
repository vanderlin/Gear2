@extends('admin.layouts.default')

<?php $page = isset($page)?$page:'settings'; ?>

{{-- Web site Title --}}
@section('title')
	{{Config::get('config.site-name')}} | {{ucfirst($page)}}
@stop

{{-- Content --}}
@section('content')

	@if ($page == 'settings')
		@include('admin.settings')	
	@elseif ($page == 'users')
		@include('admin.users')		
	@elseif ($page == 'roles')
		@include('admin.roles.index')		
	@elseif ($page == 'themes')
		@include('admin.themes')	
	@elseif ($page == 'assets')
		@include('admin.assets')		
	@else 
		@include('admin.settings')
	@endif
	
@stop