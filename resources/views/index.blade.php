<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sunday Smoker</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- <link rel="stylesheet" href="{{asset ("/bower_components/bootstrap/dist/css/bootstrap.min.css")}}"> -->
  <link rel="stylesheet" href="{{asset ("/bower_components/bootstrap/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset ("/bower_components/font-awesome/css/font-awesome.min.css")}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset ("/bower_components/Ionicons/css/ionicons.min.css")}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset ("/bower_components/jvectormap/jquery-jvectormap.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset ("/bower_components/admin-lte/dist/js/adminlte.min.js")}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset ("/bower_components/admin-lte/dist/css/skins/_all-skins.min.css")}}">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('custom_style')

</head>
<body class="skin-white layout-top-nav">
  <!-- ./wrapper -->


@include('components/header')

@yield('content')

@push('scripts')
@endpush

<!-- jQuery 3 -->
<script src="{{asset ("/bower_components/jquery/dist/jquery.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="{{asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script> -->
<script src="{{asset ("/bower_components/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset ("/bower_components/fastclick/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset ("/bower_components/admin-lte/dist/js/adminlte.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset ("/bower_components/jquery-sparkline/jquery.sparkline.min.js")}}"></script>
<!-- SlimScroll -->
<script src="{{asset ("/bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}"></script>
<!-- ChartJS -->
<script src="{{asset ("/bower_components/chart.js/Chart.js")}}"></script>
<script src="{{asset ("/bower_components/jvectormap/jquery-jvectormap.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stack('scripts')
</body>
</html>