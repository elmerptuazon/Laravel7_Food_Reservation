@extends('index')

@section('custom_style')
<style>
.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}

.relative {
  position: relative;
}

img {
  max-width: 100% !important;
  max-height: 30vh !important;
  margin: auto;
}

h1 { text-align: center; font-size: 16px; }
        .rwd-line { display: block; }

@media screen and (min-width: 768px) {
    .rwd_line { display: inline; }
}

.button-border {
    outline: none;
    border: 1px solid;
    padding: 15px;
    box-shadow: 2px 15px;
}
</style>
@endsection

@section('content')
<div class="container container-remove-padding">
    <div class="relative">
        <img src="{{ asset("/images/". $food->image . "." . $food->image_type)}}" class="img-fluid" alt="{{ ucwords($food->name)}}" width="1000" height="auto">
    </div>
    <div class="container">
        <h1><span class="rwd_line">{{ wordwrap($food->description, 10, "\n", true)}}</span></h1>
        <b>Sides</b>
        <!-- <div class="col-4">
            <p>sdf</p>
        </div>
        <div class="col-4">
            <p>sdf</p>
        </div> -->
        <div class="col-4">
        @foreach($sidedish as $val)
            <img src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" class="img-fluid" alt="{{ ucwords($val->name)}}" width="100" height="100">
        @endforeach
        <button type="button" class="btn btn-light btn-lg">
        <i class="fa fa-plus-square fa-5x"></i>
        </button>
        </div>
        <div style="float: right; padding-bottom: 10px;">
        <button type="button" style="background-color:black;" class="btn btn-secondary button-border">
            <span style="color: white;">CANCEL</span>
        </button>
        <button type="button" style="background-color:red;" class="btn button-border">
            <span style="color: white;">ORDER</span>
        </button>
        </div>
        
    </div>
</div>
@endsection