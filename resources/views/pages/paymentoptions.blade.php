@extends('index')

@section('custom_style')
<style>

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
        <li class="breadcrumb-item"><a href="{{url('cart')}}" onclick="event.preventDefault(); document.getElementById('cart-form').submit();">Cart</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Payment Options</a></li>
      </ol>
    </nav>
<div class="container">
<div class="row">
        <div class="col-12">
        <h5>Information</h5>
        </div>
    </div>

    <div class="row">
        <input type="hidden" id="user_input_id" value="{{$user_info->id}}">
        <div class="col-12">
            <label>Mobile</label>
            <input type="number" id="user_input_mobile" class="form-control userInput" value="{{$user_info->mobile}}">
        </div>
        <div class="col-12">
            <label>Address</label>
            <input type="text" id="user_input_address1" class="form-control userInput" value="{{$user_info->address1}}">
        </div>
        <div class="col-6">
                <label>City</label>
                <select id="user_input_city" name="city" class="form-control userInput">
                    <option value="{{$user_info->city}}" selected>{{ ucwords($user_info->city)}}</option>
                    <option value="caloocan">{{ ucwords('caloocan')}}</option>
                    <option value="las pinas">{{ ucwords('las pinas')}}</option>
                    <option value="makati">{{ ucwords('makati')}}</option>
                    <option value="mandaluyong">{{ ucwords('mandaluyong')}}</option>
                    <option value="marikina">{{ ucwords('marikina')}}</option>
                    <option value="muntinlupa">{{ ucwords('muntinlupa')}}</option>
                    <option value="navotas">{{ ucwords('navotas')}}</option>
                    <option value="paranaque">{{ ucwords('paranaque')}}</option>
                    <option value="pasay">{{ ucwords('pasay')}}</option>
                    <option value="pasig">{{ ucwords('pasig')}}</option>
                    <option value="pateros">{{ ucwords('pateros')}}</option>
                    <option value="quezon city">{{ ucwords('quezon city')}}</option>
                    <option value="san juan">{{ ucwords('san juan')}}</option>
                    <option value="taguig">{{ ucwords('taguig')}}</option>
                    <option value="valenzuela">{{ ucwords('valenzuela')}}</option>
                </select>

        </div>
        <div class="col-6">
            <label>Province</label>
            <input type="text" id="user_input_province" class="form-control userInput" name="province" value="{{ ucwords('metro manila')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" readonly>        
        </div>
    </div>

<div class="row" style="padding-top:10px;">
   
   <div class="col-6 pr-0">
   <h5>TOTAL</h5>
   </div>
   <div class="col-6 pl-0">
   &#x20B1; <span id="order_total"></span>
   </div>
</div>


    <div class="row">
   
        <div class="col-6 pr-0">
        <h5>Payment Options</h5>
        </div>
        <div class="col-6 pl-0">
        <small>(<i>please pick one</i>)</small>
        </div>
    </div>

    <div class="row">

        <div class="col-6">
        <a href="#" id="paypalBtn">
                <img src="{{ asset("/images/paypal_logo.png")}}" class="img-fluid" id="paypalBtn" alt="Buy now with PayPal" width=100 height=100 />
            </a>
        </div>

        <div class="col-6">
        <a href="#" id="paymayaBtn">
                <img src="{{ asset("/images/paymaya_logo.png")}}" class="img-fluid"  alt="Buy now with Paymaya" width=150 height=200 />
            </a>
        </div>

    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $( document ).ready(function() {
        let sessionFoodList = sessionStorage.getItem("FOOD_LIST");
        let sessionCapacityDate = sessionStorage.getItem("CAPACITY_DATE");
        let sessionOrderTotal = sessionStorage.getItem("ORDER_TOTAL");
        let parseOrderTotal = JSON.parse(sessionOrderTotal)


        $('#order_total').text(parseOrderTotal);

        $('#paypalBtn').on('click', function() {
            let newUser = {
                id: $('#user_input_id').val(),
                mobile: $('#user_input_mobile').val(),
                address: $('#user_input_address1').val(),
                city: $('#user_input_city').val(),
                province: $('#user_input_province').val().toLowerCase(),
            }

            if($('#user_input_mobile').val() != '' && $('#user_input_address1').val() != '' && $('#user_input_city').val() != '') {
                $.post( "{{ url('payment') }}", { 
                    _token: "{{ csrf_token() }}",
                    payment_used: 'paypal',
                    cart_data: sessionFoodList,
                    date: sessionCapacityDate,
                    user_info: newUser
                }).done(function( data ) {
                    if(data.status == 1) {
                        window.location.href = data.link;
                    }else {
                        $('#alert_popup').on('show.bs.modal', function () {
                            $('#alert_popup_title').text('Error')
                            $('#alert_popup_content').text(data.message);
                        }).modal('show');
                    }
                });
            }else {
                $('#alert_popup').on('show.bs.modal', function () {
                    $('#alert_popup_title').text('Error')
                    $('#alert_popup_content').text('Please fill up all information field.');
                }).modal('show');
            }

            

        })

        $('#paymayaBtn').on('click', function() {
            let newUser = {
                id: $('#user_input_id').val(),
                mobile: $('#user_input_mobile').val(),
                address: $('#user_input_address1').val(),
                city: $('#user_input_city').val(),
                province: $('#user_input_province').val().toLowerCase(),
            }

            
            if($('#user_input_mobile').val() != '' && $('#user_input_address1').val() != '' && $('#user_input_city').val() != '') {
                $.post( "{{ url('payment') }}", { 
                    _token: "{{ csrf_token() }}",
                    payment_used: 'paymaya',
                    cart_data: sessionFoodList,
                    date: sessionCapacityDate,
                    user_info: newUser
                }).done(function( data ) {
                    if(data.status == 1) {
                        window.location.href = data.link;
                    }else {
                        $('#alert_popup').on('show.bs.modal', function () {
                            $('#alert_popup_title').text('Error')
                            $('#alert_popup_content').text(data.message);
                        }).modal('show');
                    }
                });
            }else {
                $('#alert_popup').on('show.bs.modal', function () {
                    $('#alert_popup_title').text('Error')
                    $('#alert_popup_content').text('Please fill up all information field.');
                }).modal('show');
            }
            

        })
    });
</script>
@endpush
