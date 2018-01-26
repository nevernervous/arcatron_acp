<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @yield('style')
</head>
<body>
  @if (Auth::check())
    @include('layouts.partials.navbar')
  @endif
  <div class="page-container">
    <div class="page-content">
      @if (Auth::check())
        @include('layouts.partials.sidebar')
      @endif
      <div class="content-wrapper">
        @yield('content')
      </div>

    </div>
  </div>

  <!-- Scripts -->

  <!-- Theme JS files -->
  <script src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/ui/nicescroll.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>

  <script src="{{ asset('assets/js/core/app.js') }}"></script>
  <script src="{{ asset('assets/js/pages/layout_fixed_custom.js') }}"></script>
  <!-- /theme JS files -->

  <script src="{{ asset('js/app.js') }}"></script>
  <script>
      $(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': "<?php echo csrf_token() ?>"
              }
          });
      });
  </script>
  @yield('script')
</body>
</html>
