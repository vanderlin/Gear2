
<div class="main-navbar navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="{{URL::to('/')}}">
            <!-- <img src="{{ asset('assets/content/img/hipster-logo.png') }}" style="width:100px; height:100px;" class="navbar-brand"><br> -->
            {{link_to('/', Config::get('config.site-name'), ['class'=>'navbar-brand'])}}
          </a>

        </div>
        <div class="collapse navbar-collapse">

        @if (Auth::check())
        <ul class="nav navbar-nav navbar-left">
          <li>{{ link_to( '#link-a', 'Link A') }}</li>
          <li>{{ link_to( '#link-b', 'Link B') }}</li>
          <li>{{ link_to( '#link-c', 'Link C') }}</li>
        </ul>
        @endif
          
      
        <ul class="nav navbar-nav navbar-right">
          
          @if (Auth::check())
          <li class="dropdown">
            
            <a href="/me" class="dropdown-toggle" data-toggle="dropdown">
              <img width="40" height="40" src="{{ Auth::getUser()->profileImage->url('w40') }}" class="nav-profile-image img-circle">
              {{ Auth::getUser()->getName() }}
              <span class="caret"></span>
            </a>
            
            <ul class="dropdown-menu" role="menu">
              <li>{{ link_to('/me', 'Profile') }}</li>
              @if (Auth::user()->hasRole('Editor'))
                <li>{{ link_to('admin', 'Settings') }}</li>
              @endif
              @if (Auth::getUser()->hasRole('Admin'))
                <li>{{ link_to('admin', 'Admin') }}</li>
              @endif
              <li class="divider"></li>
              <li>{{ link_to('users/logout', 'Logout') }}</li>
            </ul>

          </li>
          @else
            <li>{{ link_to('users/login', 'Login') }}</li>
          @endif

        </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>
