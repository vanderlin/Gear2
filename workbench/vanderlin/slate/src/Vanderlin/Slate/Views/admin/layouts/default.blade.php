<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>
      @section('title')
      {{Config::get('slate::site_name')}} | Admin
      @show
    </title>

    <!-- Bootstrap -->
    @include('slate::site.partials.bootstrap-head')

    <!-- Admin CSS -->
    <link href="{{asset('assets/css/admin/main.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/admin/sb-admin.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>



    <div id="wrapper">

        {{-- Navigation --}}
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            {{-- Main Menu --}}
            @include('slate::admin.layouts.top-navigation');
            {{-- Main Menu --}}

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            @include('slate::admin.layouts.sidebar')
            <!-- /.navbar-collapse -->

        </nav>















    <!-- Main Navigation -->
    {{--@include('site.layouts.main-navigation')--}}
    <!-- Main Navigation -->  

    
      {{-- Side Bar --}}
      {{--@include('admin.layouts.sidebar')--}}
      {{-- Side Bar --}}

      {{-- Admin Content --}}
       <div id="page-wrapper">

          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
                      @yield('content')
                  </div>
              </div>
              <!-- /.row -->

          </div>
          <!-- /#page-wrapper -->

      </div>
      {{-- Admin Content --}}

      
    </div>
    <!-- ./ content -->


  </body>
</html>




