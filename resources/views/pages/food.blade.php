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
    <img src="{{ asset("/images/". $food->image . "." . $food->image_type)}}" class="img-fluid" alt="{{ ucwords($food->name)}}" width="1000" height="auto">
    <div class="container">
        <div class="row">
        <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="btn btn-secondary btn-sm sumofmeat"> <i class="fa fa-minus"></i></button>
        <input class="quantity" style="width:40px;" min="1" max="10" value="1" id="meat_{{$food->id}}" type="number">
        <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="btn btn-secondary btn-sm sumofmeat"><i class="fa fa-plus"></i></button>
        <span class="badge badge-pill badge-warning" style="height: max-content; margin-top: 5px;"><span id="meatleft">{{10 -  1}}</span> left</span>  
        </div>
    </div>
    <div class="relative">
        
    <div class="container">
        <h1><span class="rwd_line">{{ wordwrap($food->description, 10, "\n", true)}}</span></h1>
        <b>Sides</b>
        <div class="col-8" style="padding-left: 0px;">
        @foreach($sidedish as $val)
            <img src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" class="img-fluid" id="food_{{$val->id}}" alt="{{ ucwords($val->name)}}" width="100" height="100">
            <div class="container">
                <div class="row">
                <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="btn btn-secondary btn-sm sumofsidedish_{{$val->id}}"> <i class="fa fa-minus"></i></button>
                <input class="quantity" style="width:40px;" min="0" value="0" id="sidedish_{{$val->id}}" type="number">
                <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="btn btn-secondary btn-sm sumofsidedish_{{$val->id}}"><i class="fa fa-plus"></i></button>
                <span class="badge badge-pill badge-warning" style="height: max-content; margin-top: 5px;"><span id="sidedishleft_{{$val->id}}">{{10}}</span> left</span>  
                </div>
            </div>
        @endforeach
        </div>
        <div style="float: right; padding-bottom: 10px;">
        <button type="button" style="background-color:black;" class="btn button-border">
            <span style="color: white;">CANCEL</span>
        </button>
        <button type="button" style="background-color:red;" id="submitOrder" class="btn button-border">
            <span style="color: white;">ORDER</span>
        </button>
        </div>
        
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$( document ).ready(function() {
    const FOOD_LIST = {};
    FOOD_LIST['meat'] = {};
    FOOD_LIST['sidedish'] = {};

    let food_objects = {};
    food_objects.meatId = {!! json_encode($food->id) !!};
    food_objects.meatOrder = $('#meat_{{$food->id}}').val();
    $(".sumofmeat").bind("click", function(){
        $('#meatleft').text(10 - $('#meat_{{$food->id}}').val());
        food_objects.meatId = {!! json_encode($food->id) !!};
        food_objects.meatOrder = $('#meat_{{$food->id}}').val();
    });
    FOOD_LIST['meat'][food_objects.meatId] = food_objects.meatOrder

    let sidedishArray = {!! json_encode($sidedish) !!}
    
    for(let i = 0; i <= sidedishArray.length-1; i++) {
        $(".sumofsidedish_"+sidedishArray[i].id).bind("click", function(){
            
            $('#sidedishleft_'+sidedishArray[i].id).text(10 - $('#sidedish_'+sidedishArray[i].id).val());

            if($('#sidedish_'+sidedishArray[i].id).val() != 0) {
                food_objects['sidedishid_' + sidedishArray[i].id] = sidedishArray[i].id
                food_objects['sidedishorder_' + sidedishArray[i].id] = $('#sidedish_'+sidedishArray[i].id).val();
            }else {
                food_objects['sidedishid_' + sidedishArray[i].id] = sidedishArray[i].id
                food_objects['sidedishorder_' + sidedishArray[i].id] = 0;

            }

            FOOD_LIST['sidedish'][food_objects['sidedishid_' + sidedishArray[i].id]] = food_objects['sidedishorder_' + sidedishArray[i].id]
        });
    }
    
    $('#submitOrder').on('click', function() {
        // console.log("http://localhost:8000/order/" + JSON.stringify(FOOD_LIST))
        window.location.href = "http://localhost:8000/order/" + JSON.stringify(FOOD_LIST);
    })
});
</script>
@endpush