@extends('index')

@section('custom_style')
<style>

h1 { text-align: center; font-size: 16px; }
        .rwd-line { display: block; }

@media screen and (min-width: 768px) {
    .rwd_line { display: inline; }
}

.card {
    overflow: hidden;
    border-radius: 6px;
    position: relative;
    background-color: #FFFFFF;
    box-shadow: 0 1px 2px rgba(0,0,0,0.15);
    margin-bottom: 30px;
}
.card-small .thumbnail {
    min-height: 30vh;
}

.card .thumbnail {
    border: 0 none;
    padding: 0;
    margin: 0;
    position: relative;
}

.card .thumbnail img {
    width: 100%;
}

.card .thumb-cover {
    padding: 15px 20px;
    height: 100%;
    top: 0;
    position: absolute;
    bottom: 0;
    opacity: 0;
    width: 100%;
    background-color: rgba(255,255,255,0.95);
}
.thumb-cover{
 transition: all 0.2s ease 0s;
-webkit-transition: all 0.2s ease 0s;   
}

.card .details {
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJod…IgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
    background: -moz-linear-gradient(top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 62%, rgba(0,0,0,0) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0,0,0,0.75)), color-stop(62%, rgba(0,0,0,0.36)), color-stop(100%, rgba(0,0,0,0)));
    background: -webkit-linear-gradient(top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 62%, rgba(0,0,0,0) 100%);
    background: -o-linear-gradient(top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 62%, rgba(0,0,0,0) 100%);
    background: -ms-linear-gradient(top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 62%, rgba(0,0,0,0) 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.36) 62%, rgba(0,0,0,0) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5e000000', endColorstr='#00000000',GradientType=0 );
    top: 0;
    display: block;
    padding: 10px 15px 0;
    width: 100%;
}

.card .user {
    font-weight: 400;
    color: #FFFFFF;
    text-shadow: 0 1px 2px rgba(0,0,0,0.23);
    line-height: 20px;
    display: block;
}

.hidden {
    display: none !important;
    visibility: hidden !important;
}

.card .user .user-photo {
    width: 35px;
    height: 35px;
    border: 2px solid #FFFFFF;
    border-radius: 50%;
    overflow: hidden;
    float: left;
}

.card .user .name {
    line-height: 35px;
    margin-left: 10px;
    font-size: 16px;
    float: left;
}

.card .numbers {
    color: #FFFFFF;
    float: right;
    margin-top: 6px;
}

.card .numbers .downloads, .card .numbers .comments-icon {
    margin-left: 6px;
    font-size: 15px;
    font-weight: 500;
}

.card .numbers .fa {
    font-size: 18px;
}

.card .numbers .downloads, .card .numbers .comments-icon {
    margin-left: 6px;
    font-size: 15px;
    font-weight: 500;
}

.card-info {
    background-color: #FFFFFF;
    position: relative;
    height: 120px;
}
.card-info {
  -moz-osx-font-smoothing: grayscale;
 -webkit-font-smoothing: antialiased;  
}

.card-info .moving {
    padding: 15px;
    background-color: #FFFFFF;
    position: relative;
    -webkit-animation-duration: 1s;
    -moz-animation-duration: 1s;
    -o-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    -moz-animation-fill-mode: both;
    -o-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-name: returnBounce;
    -moz-animation-name: returnBounce;
    -ms-animation-name: returnBounce;
    -o-animation-name: returnBounce;
    animation-name: returnBounce;
}

.card-info a {
    color: #434343;
}

.card-small .card-info h3 {
    font-size: 18px;
}
.card-info h3 {
    margin-top: 0;
    font-size: 22px;
}

.card-info h3 {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
}

.card-info p {
    font-size: 14px;
    font-style: italic;
    margin: 0;
    color: #666666;
    height: 60px;
}

.card-small .actions {
    height: 55px;
    font-size: 14px;
}

.card .actions {
    background-color: #FFFFFF;
    bottom: -80px;
    color: rgba(33,33,33,0.79);
    display: block;
    height: 80px;
    left: 0;
    opacity: 1;
    position: absolute;
    text-align: center;
    width: 100%;
    font-size: 18px;
}

.card-info .actions a {
    color: #777777;
}

.card .actions a {
    font-weight: 400;
}

.card .separator {
    padding: 0 7px;
    font-weight: 400;
    color: #CCCCCC;
}

.card-info .actions .blue-text {
    color: #00bbff;
}
a, a:hover, a:focus, .btn:focus, .btn:hover, .btn:active, .btn:active:focus, .btn:active.focus, .btn.active:focus, .btn.active.focus {
    text-decoration: none;
    outline: 0;
    outline-color: transparent;
    outline-style: none;
}

.qty .count {
    color: #000;
    display: inline-block;
    vertical-align: top;
    font-size: 25px;
    font-weight: 700;
    line-height: 30px;
    padding: 0 2px
    ;min-width: 35px;
    text-align: center;
}
.qty .plus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    }
.qty .minus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    background-clip: padding-box;
}
div {
    text-align: center;
}
.minus:hover{
    background-color: #717fe0 !important;
}
.plus:hover{
    background-color: #717fe0 !important;
}
/*Prevent text selection*/
span{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
input{  
    border: 0;
    width: 2%;
}
nput::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input:disabled{
    background-color:white;
}

.button-border {
    outline: none;
    border: 1px solid;
    padding: 15px;
    box-shadow: 2px 5px;
}
.col-xs-12.col-sm-10.col-md-10.col-lg-10{
    padding-left: 0;
    padding-right: 0;
}
.col-xs-12.col-sm-4.col-md-4.col-lg-4{
    padding-left: 0;
    padding-right: 0;
}
</style>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/food/{{$food->id}}">{{ ucwords($food->name)}}</a></li>
      </ol>
    </nav>

<div class="container">
<div class="row">
<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
    <div class="card card-small">
        <div class="thumbnail">       
        <div id="meat_max_pcs{{$food->id}}" data-field-id="{{$food->current_max_pcs}}"></div>
                <img alt="{{ ucwords($food->name)}}" src="{{ asset("/images/". $food->image . "." . $food->image_type)}}">

                <div class="qty mt-2">
                    <span onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus bg-dark sumofmeat">-</span>
                    <input type="number" min="1" max="{{$food->current_max_pcs}}" value="1" id="meat_{{$food->id}}" class="count" name="qty" disabled>
                    <span onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus bg-dark sumofmeat">+</span>
                    <span class="badge badge-pill badge-warning" style="height: max-content; margin-top: 5px;"><span id="meatleft">{{$food->current_max_pcs -1}}</span> left</span>  
                </div>
                <div class="clearfix"></div>
                <h3>{{ ucwords($food->name)}}</h3>
                <p class="rwd_line">{{ wordwrap($food->description, 10, "\n", true)}}</p>

        </div>
        <!-- <div class="card-info">
            <div class="moving">
                            <h3>{{ ucwords($food->name)}}</h3>
                <p class="rwd_line">{{ wordwrap($food->description, 10, "\n", true)}}</p>

            </div>
        </div> -->
    </div>
</div>

<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
<h5>Sidedish</h5>
</div>

@foreach($sidedish as $val)
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
<div class="card card-small">
        <div class="thumbnail">       
        <div id="sidedish_max_pcs{{$val->id}}" data-field-id="{{$val->max_pcs_per_tray}}" ></div>
                <img alt="{{ ucwords($val->name)}}" src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" width="300" height="300">

                <div class="qty mt-2">
                    <span onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus bg-dark sumofsidedish_{{$val->id}}">-</span>
                    <input type="number" class="count" min="0" max="{{$val->max_pcs_per_tray}}" value="0" id="sidedish_{{$val->id}}" disabled>
                    <span onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus bg-dark sumofsidedish_{{$val->id}}">+</span>
                    <span class="badge badge-pill badge-warning" style="height: max-content; margin-top: 5px;"><span id="sidedishleft_{{$val->id}}">{{$val->max_pcs_per_tray}}</span> left</span>  
                </div>
                <div class="clearfix"></div>
                <h3>{{ ucwords($val->name)}}</h3>
                <p class="rwd_line">{{ wordwrap($val->description, 10, "\n", true)}}</p>
        </div>
        <!-- <div class="card-info">
            <div class="moving" style="overflow-x: scroll;">
                    
            </div>
        </div> -->
    </div>
</div>
@endforeach
<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" style="padding-bottom: 10px;">
        <a href="/"><button type="button" style="background-color:#474545;" class="btn button-border">
            <span style="color: white;">CANCEL</span>
        </button></a>
        <a href="{{url('cart')}}" onclick="event.preventDefault(); document.getElementById('cart-form').submit();"><button type="button" style="background-color:#790F0F;" id="submitOrder" class="btn button-border">
            <span style="color: white;">ORDER</span>
        </button></a>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
$( document ).ready(function() {
    let sessionFoodList = sessionStorage.getItem("FOOD_LIST");

    let parseFoodList = JSON.parse(sessionFoodList);

    function countOrders(orders) {
        let labelCounter = 0;
        let sidedish = orders.sidedish

        for(let value in sidedish) {
            console.log(parseInt(orders.meat[value]))
            labelCounter += parseInt(orders.meat[value])
            for(let value2 in sidedish[value]) {
                console.log(parseInt(sidedish[value][value2]))
            labelCounter += parseInt(sidedish[value][value2])
            }      
        }
        return labelCounter;
    }

    function isEmptyFoodList() {
        if(sessionFoodList == null) {
            return true;
        }else {
            return false;
        }
    }
    let getFoodList = isEmptyFoodList() ? {} : JSON.parse(sessionFoodList);
    const FOOD_LIST = isEmptyFoodList() ? {} : getFoodList;
    
    FOOD_LIST['meat'] = isEmptyFoodList() ? {} : getFoodList.meat;
    FOOD_LIST['sidedish'] = isEmptyFoodList() ? {} : getFoodList.sidedish;
 
    let food_objects = {};
    food_objects.meatId = {!! json_encode($food->id) !!};
    
    food_objects.meatOrder = isEmptyFoodList() ? 1 : getFoodList.meat[food_objects.meatId];
    FOOD_LIST['meat'][food_objects.meatId] = 1;
    $(".sumofmeat").bind("click", function(){
        
        $('#meatleft').text($('#meat_max_pcs{{$food->id}}').data("field-id") - $('#meat_{{$food->id}}').val());
        food_objects.meatId = {!! json_encode($food->id) !!};
        food_objects.meatOrder = $('#meat_{{$food->id}}').val();
        FOOD_LIST['meat'][food_objects.meatId] = food_objects.meatOrder
    });
    let sidedishArray = {!! json_encode($sidedish) !!}
    
    FOOD_LIST['sidedish'][food_objects.meatId] = !isEmptyFoodList() && getFoodList.sidedish[food_objects.meatId] != undefined ? getFoodList.sidedish[food_objects.meatId] : {} ;
    for(let i = 0; i <= sidedishArray.length-1; i++) {
        FOOD_LIST['sidedish'][food_objects.meatId][sidedishArray[i].id] = 0;
        $(".sumofsidedish_"+sidedishArray[i].id).bind("click", function(){
            
            $('#sidedishleft_'+sidedishArray[i].id).text($('#sidedish_max_pcs'+sidedishArray[i].id).data("field-id") - $('#sidedish_'+sidedishArray[i].id).val());

            if($('#sidedish_'+sidedishArray[i].id).val() != 0) {
                food_objects['sidedishid_' + sidedishArray[i].id] = sidedishArray[i].id
                food_objects['sidedishorder_' + sidedishArray[i].id] = $('#sidedish_'+sidedishArray[i].id).val();
            }else {
                food_objects['sidedishid_' + sidedishArray[i].id] = sidedishArray[i].id
                food_objects['sidedishorder_' + sidedishArray[i].id] = 0;
            }
            FOOD_LIST['sidedish'][food_objects.meatId][food_objects['sidedishid_' + sidedishArray[i].id]] = food_objects['sidedishorder_' + sidedishArray[i].id]
        });
    }
    
    $('#submitOrder').on('click', function() {
        sessionStorage.setItem('FOOD_LIST', JSON.stringify(FOOD_LIST));
        let cart_data = sessionStorage.getItem("FOOD_LIST");
        $('#session_cart_data').val(cart_data);
        let parseCart_Data = JSON.parse(cart_data);
        sessionStorage.setItem('CART_COUNT', countOrders(parseCart_Data))
        window.location.href = "{{url('order')}}"+ "/" + food_objects.meatId;
    })
});
</script>
@endpush