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
                <small><strong><span>&#x20B1;</span> {{ number_format($meat_list->unit_price,2)}}</strong></small>
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
                <small><strong><span>&#x20B1;</span> {{ number_format($val->unit_price,2)}}</strong></small>
                </div>
            </div>
        </div>
    </div>
@endforeach

@isset($calendar_capacity)
    @if(!$calendar_capacity->active)
    <div id="capacity_date" data-field-id="{{$calendar_capacity->to_date}}" ></div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center pt-2 pb-2">
            <strong>ATTENTION</strong> <i class="fa fa-exclamation-triangle" style="color:#b50e35"></i>  
            </div>
            <div class="col-12 text-center pb-2">
                Due to the high-demand of Sunday Smoker BBQs,
                the next date we can deliver will be on 
                <u>{{ \Carbon\Carbon::parse($calendar_capacity->to_date)->addDays(1)->format('F d, Y') }}</u>
            </div>
        
            <div class="col-12 text-center">
                To continue to order, tap on Reserve & Pay below
                or Select a <strong><span style="color:blue" class="datepicker"><u>Different Date</u></span></strong>
                <input placeholder="Selected date" type="text" style="text-align:center;" class="form-control datepicker">
            </div>
        </div>
    </div>
    @endif
@endisset

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

@push('scripts')
<script>
$( document ).ready(function() {

    let capacity_date = $('#capacity_date').data("field-id");

    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "auto",
        minDate: capacity_date ? moment(capacity_date).add(1, 'days').format("MMMM DD, YYYY") : moment().format("MMMM DD, YYYY"),
        applyButtonClasses: "btn-warning",
        autoApply: true,
        locale: {
            format: "MMMM DD, YYYY",
            applyLabel: "Confirm",
        },
    }, function(start, end, label) {
        // console.log("A new date selection was made: "+ label+ ' ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
    
});
</script>
@endpush