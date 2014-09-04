
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">{{ Config::get('config.site-name') }}</a>
</div>

<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
	@if (Auth::check())
	<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>{{Auth::getUser()->username}}<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="/me"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            @if (Auth::getUser()->hasRole('Admin'))
	        	<li>{{ link_to('admin', 'Admin') }}</li>
	        @endif
	        
            <li class="divider"></li>
            <li>
                <a href="/users/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>	
	@else
		<li>{{ link_to('users/login', 'Login') }}</li>  		
    @endif
</ul>
<!-- Top Menu Items -->