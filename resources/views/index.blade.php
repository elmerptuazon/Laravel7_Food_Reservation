<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sunday Smoker</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset ("/bower_components/bootstrap/css/bootstrap.min.css")}}">
  <link rel="stylesheet" href="{{asset ("/bower_components/font-awesome/css/font-awesome.min.css")}}">
  <link rel="stylesheet" href="{{asset ("/bower_components/jquery-ui/jquery-ui.min.css")}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{{asset ("/bower_components/daterange/daterangepicker.css")}}">
    @yield('custom_style')
    <style>
    .badge {
      padding-left: 9px;
      padding-right: 9px;
      -webkit-border-radius: 9px;
      -moz-border-radius: 9px;
      border-radius: 9px;
    }

    .label-warning[href],
    .badge-warning[href] {
      background-color: #c67605;
    }
    #lblCartCount {
        font-size: 15px;
        background: #ff0000;
        color: #fff;
        padding: 0 5px;
        vertical-align: top;
        margin-left: -10px; 
    }
    </style>
</head>
<body>
  <!-- ./wrapper -->
@include('components/header')

<div class="container pr-0 pl-0" style=" overflow-x: scroll; height: 90vh;">
@yield('content')
</div>

<script src="{{asset ("/bower_components/jquery-ui/external/jquery/jquery.js")}}"></script>
<script src="{{asset ("/bower_components/jquery-ui/jquery-ui.min.js")}}"></script>
<script src="{{asset ("/bower_components/bootstrap/js/bootstrap.min.js")}}"></script>
<script src="{{asset ("/bower_components/daterange/moment.min.js")}}"></script>
<script src="{{asset ("/bower_components/daterange/daterangepicker.min.js")}}"></script>
<script>
$( document ).ready(function() {
  const isFieldExists = document.getElementById("session_cart_data");
  if(isFieldExists !== null) {
    let cart_data = sessionStorage.getItem("FOOD_LIST");
    $('#session_cart_data').val(cart_data);
  }

  const isCartCountExists = document.getElementById("lblCartCount");
  if(isCartCountExists !== null) {
    let cart_count = sessionStorage.getItem("CART_COUNT");
    if(cart_count != null) {
      $('#lblCartCount').text(cart_count);
    }else {
      $('#lblCartCount').text(0);
    }
    
  }
});
</script>
@stack('scripts')
</body>
</html>