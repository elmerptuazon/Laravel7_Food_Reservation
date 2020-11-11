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
        {{--<li class="breadcrumb-item"><a href="/food/{{$meat_list->id}}">{{ ucwords($meat_list->name)}}</a></li>--}}
        <li class="breadcrumb-item"><a href="#">meat name</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Reserve & Pay</a></li>
      </ol>
    </nav>
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
    // let meat_list = $('#meat_list').data("field-id");
    let meat_list = 0
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
                $('#alert_popup').on('show.bs.modal', function () {
                  $('#alert_popup_title').text('Error')
                  $('#alert_popup_content').text(data.error);
                }).modal('show');
                return false;
            }else {
                $('#alert_popup').on('show.bs.modal', function () {
                  $('#alert_popup_title').text('Error')
                  $('#alert_popup_content').text(data.error);
                }).modal('show');
                return false;
            }
        }
      });

})
  
    
});
</script>
@endpush