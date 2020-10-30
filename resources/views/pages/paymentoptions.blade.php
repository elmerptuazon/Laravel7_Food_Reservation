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
<div class="container">
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

        $('#paypalBtn').on('click', function() {

            $.post( "{{ url('payment') }}", { 
                payment_used: 'paypal',
                meat_list: details.meat_list, 
                sidedish_list: details.sidedish_list,
                date: details.date,
                tray_remaining: details.tray_remaining,
                tray_id: details.tray_id
            }).done(function( data ) {
                if(data.status == 1) {
                    window.location.href = data.link;
                }else {
                    alert(data.message);
                }
            });

        })

        $('#paymayaBtn').on('click', function() {

            $.post( "{{ url('payment') }}", { 
                payment_used: 'paymaya',
                meat_list: details.meat_list, 
                sidedish_list: details.sidedish_list,
                date: details.date,
                tray_remaining: details.tray_remaining,
                tray_id: details.tray_id
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
