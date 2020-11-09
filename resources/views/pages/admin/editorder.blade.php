@extends('admin')

@section('content')
    <nav aria-label="breadcrumb">   
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/order">Order</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Order Update</a></li>
      </ol>
    </nav>
<div class="alert alert-success successText" style="display:none">
    Success
</div>
    <div class="container">
        <div class="row">
        <div id="capacity_date" data-field-id="{{$order->created_at}}" ></div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">First Name</span>
                    </div>
                    <input type="text" class="form-control" value="{{ucwords($order->fname)}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Last Name</span>
                    </div>
                    <input type="text" class="form-control" value="{{ucwords($order->lname)}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                </div>
            </div>
            <div class="col-5">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Paid</span>
                    </div>
                    <select class="form-control" id="paid" name="cars">
                        <option selected="selected" value="{{ $order->status }}">{{ $order->status ? 'Yes' : 'No' }}</option>
                        <option value="{{ !$order->status != 0 ? 1 : 0  }}">{{ !$order->status ? 'Yes' : 'No' }}</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Delivery Fee</span>
                    </div>
                    <input type="number" id="deliveryfee" class="form-control" value="{{ $order->delivery_fee != null ? $order->delivery_fee : 0 }}" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-8">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Total</span>
                    </div>
                    <input type="number" id="totalfee" class="form-control" value="{{ $order->total_price }}" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
                    </div>
                    <input id="selectedDate" placeholder="Selected date" type="text" class="form-control datepicker" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
        </div>
        <a href="/admin/order"><button type="button" class="btn btn-danger" data-dismiss="modal">BACK</button></a>
        <button type="button" id="updateOrder" class="btn btn-primary">UPDATE</button>
    </div>

@endsection

@push('scripts')
<script>
$( document ).ready(function() {
let capacity_date = $('#capacity_date').data("field-id");
let timeNow = moment().format("HH:mm:ss");

    $('.successText').hide();
    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "down",
        startDate: capacity_date ? moment(capacity_date).format("MMMM DD, YYYY") : moment().format("MMMM DD, YYYY"),
        applyButtonClasses: "btn-warning",
        autoApply: true,
        locale: {
            format: "MMMM DD, YYYY",
            applyLabel: "Confirm",
        },
    }, function(start, end, label) {
        $('#selectedDate').val(start.format("YYYY-MM-DD") + ' ' + timeNow)
        capacity_date = moment(start).format("YYYY-MM-DD " + timeNow);
        // console.log("A new date selection was made: "+ label+ ' ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });

  $('#updateOrder').on('click', function() {
    $('#selectedDate').val(moment(capacity_date).format("YYYY-MM-DD " + timeNow));
    capacity_date = moment(capacity_date).format("YYYY-MM-DD " + timeNow);
        $.ajax( {
            type: "PUT",
            url: "{{ url('admin/order/'.$order->id)}}",
            data: { 
                _token: "{{ csrf_token() }}",
                paid: $('#paid').val(), 
                deliveryfee: $('#deliveryfee').val(), 
                totalfee: $('#totalfee').val(), 
                date: $('#selectedDate').val() 
            },
            success: function(data) {
                if(data.status) {
                    location.reload();
                    $('.successText').show();
                    setTimeout(function(){ $('.successText').fadeOut() }, 2000);
                }
            }
        });
   
  });
});
</script>
@endpush