@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{Config::get('config.site_name')}} | Admin
@stop

{{-- Content --}}
@section('content')
	@include('admin.users')
@stop