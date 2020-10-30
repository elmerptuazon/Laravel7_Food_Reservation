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
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ ucwords($meat_list->name)}}</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Reserve & Pay</a></li>
      </ol>
    </nav>
<div class="container">
    <div id="meat_list" data-field-id="{{$meat_list}}" ></div>
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
    <div id="sidedish_list" data-field-id="{{ json_encode($sidedish_list) }}" ></div>
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
<div id="capacity_date" data-field-id="{{$calendar_capacity->to_date}}" ></div>
    @if(!$calendar_capacity->active)
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
        
        </div>
    </div>
    @endif
@endisset
        <div class="anotherDate">
            <div class="col-12 text-center">
                To continue to order, tap on Reserve & Pay below
                or Select a <strong><span style="color:blue"><u>Different Date</u></span></strong>
                <input placeholder="Selected date" type="text" style="text-align:center;" class="form-control datepicker">
            </div>
        </div>
</div>
<div class="container" style="padding-top: 20%">
    <div class="row">
        <div class="col-12 text-center">
        <button type="button" style="background-color:#790F0F;" id="submitOrder" class="btn button-border">
            <span style="color: white;">RESERVE & PAY</span>
        </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$( document ).ready(function() {

    let capacity_date = moment().format("YYYY-MM-DD");
    let meat_list = $('#meat_list').data("field-id");
    let sidedish_list = $('#sidedish_list').data("field-id");
    
   
    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "down",
        minDate: moment().format("MMMM DD, YYYY"),
        applyButtonClasses: "btn-warning",
        // autoApply: true,
        locale: {
            format: "MMMM DD, YYYY",
            applyLabel: "Confirm",
        },
    }, function(start, end, label) {
        capacity_date = start.format('YYYY-MM-DD');
        
        // console.log("A new date selection was made: "+ label+ ' ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
    

$('#submitOrder').on('click', function() {
    
    $.post( "{{ url('order/validation') }}", { 
        meat_list: meat_list, 
        sidedish_list: sidedish_list,
        date: capacity_date
    }).done(function( data ) {
        
        if(data.status) {
            window.location.href =  "{{url('payment')}}"+"/?details="+JSON.stringify(data.details);
        }else if(data.error) {
            if(data.error_id == 1) {
                alert(data.error)
                return false;
            }else {
                alert(data.error)
                return false;
            }
        }
      });

})
  
    
});
</script>
@endpush