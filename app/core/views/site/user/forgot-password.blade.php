


@extends('slate::site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{Config::get('slate::site-name')}} | Login
@stop




{{-- Head --}}
@section('head')
@stop



{{-- Content --}}
@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6"><h4>Forgot Password</h4></div>
                    <div class="col-md-6 text-right"><h6>{{ link_to('/login', 'Login', ['type'=>'submit', 'class'=>'']) }}</h6></div>
                </div>
            </div>
            
            <div class="panel-body">
                @include('slate::site.user.forgot-password-form')
            </div>

        </div>

        
        <div id="form-information" class="text-center">
            @include('slate::site.partials.form-errors')
        </div>


    </div>

@stop






























