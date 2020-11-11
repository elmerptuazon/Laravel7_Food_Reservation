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

            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>First Name</small></span>
                    </div>
                    <input type="text" id="fnameinput" class="form-control"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->fname}}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Last Name</small></span>
                    </div>
                    <input type="text" id="lnameinput" class="form-control"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->lname}}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Mobile No.</small></span>
                    </div>
                    <input type="number" id="mobileno" class="form-control"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->mobile}}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Email</small></span>
                    </div>
                    <input type="text" id="emailinput" class="form-control"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->email}}" readonly>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Address</small></span>
                    </div>
                    <input type="text" id="addressinput" class="form-control"  aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->address1}}" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>City</small></span>
                    </div>
                    <input type="text" id="cityinput" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->city}}" readonly>        
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Province</small></span>
                    </div>
                    <input type="text" id="provinceinput" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$user_info->province}}" readonly>        
                </div>
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

        $('#paypalBtn').on('click', function() {
            $.post( "{{ url('payment') }}", { 
                _token: "{{ csrf_token() }}",
                payment_used: 'paypal',
                cart_data: sessionFoodList,
                date: sessionCapacityDate
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

        })

        $('#paymayaBtn').on('click', function() {
            $.post( "{{ url('payment') }}", { 
                _token: "{{ csrf_token() }}",
                payment_used: 'paymaya',
                cart_data: sessionFoodList,
                date: sessionCapacityDate
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

        })
    });
</script>
@endpush
