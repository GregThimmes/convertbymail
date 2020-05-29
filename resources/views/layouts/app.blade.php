<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


  <title>
    Convert By Mail
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

   <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets') }}/dashboard/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/assets/vendor/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/assets/vendor/sweetalert2/dist/sweetalert2.min.css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{ asset('assets') }}/dashboard/css/dashboard.css" type="text/css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/ag-grid/23.1.1/styles/ag-grid.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/ag-grid/23.1.1/styles/ag-theme-material.min.css" />

</head>

<body class="{{ $class ?? '' }}">
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
  </noscript>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div class="main-content" id="panel">
    @auth
      @include('layouts.page_template.auth')
    @endauth
    @guest
      @include('layouts.page_template.guest')
    @endguest
  </div>

  <script src="{{ asset('assets') }}/dashboard/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{ asset('assets') }}/dashboard/assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="{{ asset('assets') }}/dashboard/assets/js/dashboard.js?v=1.2.0"></script>
  <!-- AG GRID -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ag-grid/23.1.1/ag-grid-community.min.js"></script>
  @stack('js')
</body>

</html>