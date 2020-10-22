<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ADMIN Sunday Smoker</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset ("/bower_components/bootstrap/css/bootstrap.min.css")}}">
  <link rel="stylesheet" href="{{asset ("/bower_components/font-awesome/css/font-awesome.min.css")}}">
  <link rel="stylesheet" href="{{asset ("/bower_components/jquery-ui/jquery-ui.min.css")}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{{asset ("/bower_components/daterange/daterangepicker.css")}}">
    @yield('custom_style')

</head>
<body class="skin-white layout-top-nav">
  <!-- ./wrapper -->


@include('components.admin.header')

@yield('content')

<script src="{{asset ("/bower_components/jquery-ui/external/jquery/jquery.js")}}"></script>
<script src="{{asset ("/bower_components/jquery-ui/jquery-ui.min.js")}}"></script>
<script src="{{asset ("/bower_components/bootstrap/js/bootstrap.min.js")}}"></script>
<script src="{{asset ("/bower_components/daterange/moment.min.js")}}"></script>
<script src="{{asset ("/bower_components/daterange/daterangepicker.min.js")}}"></script>
@stack('scripts')
</body>
</html>