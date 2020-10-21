@extends('index')

@section('custom_style')
<style>
.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}

.button-border {
    outline: none;
    border: 1px solid;
    padding: 15px;
    box-shadow: 2px 5px;
}

</style>
@endsection

@section('content')
<div class="container">
    <div class="row" style="padding-top: 10px;">
        <div class="col-4 pr-0">
            <img src="{{ asset("/images/". $meat_list->image . "." . $meat_list->image_type)}}" class="img-fluid" id="food_{{$meat_list->id}}" alt="{{ ucwords($meat_list->name)}}" width="100" height="100">
        </div>
        <div class="col-4 pr-0 pl-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <small><strong>{{ ucwords($meat_list->name)}}</strong></small>
                    </div>
                    <div class="col-12">
                    <small>{{ $meat_list->weight }}</small>
                    </div>
                    <div class="col-12">
                    <small>{{ $meat_list->procedure }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1 pr-0 pl-0">
            ({{ $meat_list->order }})
        </div>
        <div class="col-3 pl-0">
            <div class="row">
                <div class="col-12">
                <small><strong><span>&#x20B1;</span> {{ number_format($meat_list->price,2)}}</strong></small>
                </div>
            </div>
        </div>
    </div>

@foreach($sidedish_list as $val)
    <div class="row" style="padding-top: 10px;">
        <div class="col-4 pr-0">
            <img src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" class="img-fluid" id="food_{{$val->id}}" alt="{{ ucwords($val->name)}}" width="100" height="100">
        </div>
        <div class="col-4 pr-0 pl-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <small><strong>{{ ucwords($val->name)}}</strong></small>
                    </div>
                    <div class="col-12">
                    <small>{{ $val->weight }}</small>
                    </div>
                    <div class="col-12">
                    <small>{{ $val->procedure }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1 pr-0 pl-0">
            ({{ $val->order }})
        </div>
        <div class="col-3 pl-0">
            <div class="row">
                <div class="col-12">
                <small><strong><span>&#x20B1;</span> {{ number_format($val->price,2)}}</strong></small>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="container">
    <div class="row">
        <div class="col-12 text-center pt-2 pb-2">
        <strong>ATTENTION</strong> <i class="fa fa-exclamation-triangle" style="color:#b50e35"></i>  
        </div>
        <div class="col-12 text-center pb-2">
            Due to the high-demand of Sunday Smoker BBQs,
            the next date we can deliver will be on 
            October 23, 2020
        </div>
       
        <div class="col-12 text-center">
            To continue to order, tap on Reserve & Pay below
            or Select a <a href="#"><strong>Different Date</strong></a>
        </div>
    </div>
</div>


</div>
<div class="container" style="padding-top: 20%">
    <div class="row">
        <div class="col-12 text-center">
        <button type="button" style="background-color:red;" id="submitOrder" class="btn button-border">
            <span style="color: white;">RESERVE & PAY</span>
        </button>
        </div>
    </div>
</div>
@endsection