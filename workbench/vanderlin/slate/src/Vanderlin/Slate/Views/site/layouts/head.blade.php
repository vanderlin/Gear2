<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
  @section('title')
  {{Config::get('slate::config.site_name')}}
  @show
</title>

<!-- Bootstrap -->
@include('slate::site.partials.bootstrap-head')
<script src="{{ asset('assets/js/jquery.hoverIntent.js') }}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
<link href="{{asset('assets/css/main.css')}}" rel="stylesheet">

<?php $active_theme = Theme::activeTheme() ?>
@if ($active_theme) 
	{{ $active_theme->headCode }}
@endif

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->