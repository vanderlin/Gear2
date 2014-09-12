<!DOCTYPE html>
<html lang="en">
  <head>
    @include('slate::site.layouts.head')
    @yield('head')
  </head>
  <body>

    <!-- Main Navigation -->
    @include('slate::site.layouts.main-navigation')
    <!-- Main Navigation -->  

    <!-- Content -->
    @if (array_key_exists('content', View::getSections()))
        <div class="container main-content">
          @yield('content')
        </div>
    @endif


    @if (array_key_exists('fullwidth-content', View::getSections()))
      <div class="container-fluid">
        @yield('fullwidth-content')
      </div>
    @endif
    <!-- ./ content -->

    {{-- JS Scripts --}}
    @yield('scripts')
    {{-- JS Scripts --}}

  </body>
</html>




