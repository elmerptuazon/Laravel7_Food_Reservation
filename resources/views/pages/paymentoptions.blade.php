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
        <li class="breadcrumb-item"><a href="/food/{{$meat->id}}">{{ ucwords($meat->name)}}</a></li>
        <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Reserve & Pay</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">User Info</a></li>
      </ol>
    </nav>
<div class="container">
<div class="row">
        <div class="col-12">
        <h5>Information</h5>
        </div>
    </div>

<div class="row">

<div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>First Name</small></span>
                    </div>
                    <input type="text" id="fnameinput" class="form-control" value="" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Last Name</small></span>
                    </div>
                    <input type="text" id="lnameinput" class="form-control" value="" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Mobile No.</small></span>
                    </div>
                    <input type="number" id="mobileno" class="form-control" value="" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Email</small></span>
                    </div>
                    <input type="text" id="emailinput" class="form-control" value="" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Address</small></span>
                    </div>
                    <input type="text" id="addressinput" class="form-control" value="" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>City</small></span>
                    </div>
                    <select id="cityinput" size=3>
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
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><small>Province</small></span>
                    </div>
                    <input type="text" id="provinceinput" class="form-control" value="{{ ucwords('metro manila')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>        
                </div>
            </div>
        </div>


</div>

    <div class="row">
    <div id="details" data-field-id="{{$details}}" ></div>
        <div class="col-12">
        <h5>Payment Options</h5>
        </div>

    </div>

    <div class="row">

        <div class="col-6">
            <button type="button" style="background-color:#790F0F;" id="paypalBtn" class="btn button-border">
                <span style="color: white;">PAYPAL</span>
            </button>
        </div>

        <div class="col-6">
            <button type="button" style="background-color:#790F0F;" id="paymayaBtn" class="btn button-border">
                <span style="color: white;">PAYMAYA</span>
            </button>
        </div>

    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $( document ).ready(function() {
        let details = $('#details').data("field-id");

        function validateUserInput() {
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if(testEmail.test($('#emailinput').val()) == false) {
                alert('Please input correct email format.') 
                return false;
            }
            if($('#fnameinput').val() != '' && $('#lnameinput').val() != '' && $('#mobileno').val() != '' && $('#emailinput').val() != '' && $('#addressinput').val() != '' && $('#cityinput').val() != null) {
                return true;
            } else {
                return false;
            }
        }

        function getUserInfo() {
            let userdetails = {
                'fname': $('#fnameinput').val(),
                'lname': $('#lnameinput').val(),
                'mobile': $('#mobileno').val(),
                'email' : $('#emailinput').val(),
                'address': $('#addressinput').val(),
                'city': $('#cityinput').val(),
                'province': $('#provinceinput').val().toLowerCase()
            };

            return userdetails;
        }

        $('#paypalBtn').on('click', function() {
            if(!validateUserInput()) { alert('Please fill up all the informatioin fields.')}
            $.post( "{{ url('payment') }}", { 
                payment_used: 'paypal',
                meat_list: details.meat_list, 
                sidedish_list: details.sidedish_list,
                date: details.date,
                tray_remaining: details.tray_remaining,
                tray_id: details.tray_id,
                user_info: getUserInfo()
            }).done(function( data ) {
                if(data.status == 1) {
                    window.location.href = data.link;
                }else {
                    alert(data.message);
                }
            });

        })

        $('#paymayaBtn').on('click', function() {
            if(!validateUserInput()) { alert('Please fill up all the informatioin fields.')}
            $.post( "{{ url('payment') }}", { 
                payment_used: 'paymaya',
                meat_list: details.meat_list, 
                sidedish_list: details.sidedish_list,
                date: details.date,
                tray_remaining: details.tray_remaining,
                tray_id: details.tray_id,
                user_info: getUserInfo()
            }).done(function( data ) {
                if(data.status == 1) {
                    window.location.href = data.link;
                }else {
                    alert(data.message);
                }
            });

        })
    });
</script>
@endpush
