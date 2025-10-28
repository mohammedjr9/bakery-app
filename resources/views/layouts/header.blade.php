<head>
  <meta charset="utf-8" />
  <title>{{ config('app.name') }}</title>
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->

  <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{asset('assets/vendor/fonts/tabler-icons.css') }}" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css') }}" />


  <!-- Core CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css"/>
  <link rel="stylesheet" href="{{asset('assets/css/demo.css') }}" />

  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/toastr/toastr.css') }}" />
  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="shortcut icon" href="{{asset('assets/img/logo.ico')}}" />
  <!-- Helpers -->
  <script src="{{asset('assets/vendor/js/helpers.js') }}"></script>

  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .swal2-container {
            z-index: 20000 !important;
        }
    </style>
  @stack('css')
</head>
