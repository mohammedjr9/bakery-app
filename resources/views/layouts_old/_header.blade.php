
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مشروع توزيع الطرود -IHH</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="{{asset('plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('dist/css/font.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link href="{{asset('plugins/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome -->
    <!-- DataTables -->

    <!-- Theme style -->

  </head>
<!--end::Global Stylesheets Bundle-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
var base_url = '{{URL::to('/')}}';
</script>
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
@stack('css')
</head>
