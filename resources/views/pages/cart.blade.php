@extends('index')

@section('custom_style')
<style>
ol, ul {
  list-style: none;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

caption, th, td {
  text-align: left;
  font-weight: normal;
  vertical-align: middle;
}

q, blockquote {
  quotes: none;
}
q:before, q:after, blockquote:before, blockquote:after {
  content: "";
  content: none;
}

a img {
  border: none;
}

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
  display: block;
}

* {
  box-sizing: border-box;
}

body {
  color: #333;
  -webkit-font-smoothing: antialiased;
  /* font-family: "Droid Serif", serif; */
}

img {
  max-width: 100%;
}

.cf:before, .cf:after {
  content: " ";
  display: table;
}

.cf:after {
  clear: both;
}

.cf {
  *zoom: 1;
}

.wrap {
  width: 75%;
  max-width: 960px;
  margin: 0 auto;
  padding: 5% 0;
  margin-bottom: 5em;
}

.projTitle {
  /* font-family: "Montserrat", sans-serif; */
  font-weight: bold;
  text-align: center;
  font-size: 2em;
  padding: 1em 0;
  border-bottom: 1px solid #dadada;
  letter-spacing: 3px;
  text-transform: uppercase;
}
.projTitle span {
  /* font-family: "Droid Serif", serif; */
  font-weight: normal;
  font-style: italic;
  text-transform: lowercase;
  color: #777;
}

.heading {
  padding: 1em 0;
  border-bottom: 1px solid #D0D0D0;
}
.heading h1 {
  /* font-family: "Droid Serif", serif; */
  font-size: 2em;
  float: left;
}
.heading a.continue:link, .heading a.continue:visited {
  text-decoration: none;
  /* font-family: "Montserrat", sans-serif; */
  letter-spacing: -.015em;
  font-size: .75em;
  padding: 1em;
  color: #fff;
  background: #82ca9c;
  font-weight: bold;
  border-radius: 50px;
  float: right;
  text-align: right;
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  -ms-transition: all 0.25s linear;
  -o-transition: all 0.25s linear;
  transition: all 0.25s linear;
}
.heading a.continue:after {
  content: "\276f";
  padding: .5em;
  position: relative;
  right: 0;
  -webkit-transition: all 0.15s linear;
  -moz-transition: all 0.15s linear;
  -ms-transition: all 0.15s linear;
  -o-transition: all 0.15s linear;
  transition: all 0.15s linear;
}
.heading a.continue:hover, .heading a.continue:focus, .heading a.continue:active {
  background: #f69679;
}
.heading a.continue:hover:after, .heading a.continue:focus:after, .heading a.continue:active:after {
  right: -10px;
}

.tableHead {
  display: table;
  width: 100%;
  /* font-family: "Montserrat", sans-serif; */
  font-size: .75em;
}
.tableHead li {
  display: table-cell;
  padding: 1em 0;
  text-align: center;
}
.tableHead li.prodHeader {
  text-align: left;
}

.cart {
  padding: 1em 0;
}
.cart .items {
  display: block;
  width: 100%;
  vertical-align: middle;
  padding: 1em;
  border-bottom: 1px solid #fafafa;
}
.cart .items.even {
  background: #fafafa;
}
.cart .items .infoWrap {
  display: table;
  width: 100%;
}
.cart .items .cartSection {
  display: table-cell;
  vertical-align: middle;
}
.cart .items .cartSection .itemNumber {
  font-size: .75em;
  color: #777;
  margin-bottom: .5em;
}
.cart .items .cartSection h3 {
  font-size: 1em;
  /* font-family: "Montserrat", sans-serif; */
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: .025em;
}

.cart .items .cartSection h5 {
  font-size: .70em;
  /* font-family: "Montserrat", sans-serif; */
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: .025em;
  padding-top: 2px;
  margin-bottom: 0;
}
.cart .items .cartSection p {
  display: inline-block;
  font-size: .85em;
  color: #777777;
  /* font-family: "Montserrat", sans-serif; */
}
.cart .items .cartSection p .quantity {
  font-weight: bold;
  color: #333;
}
.cart .items .cartSection p.stockStatus {
  color: #82CA9C;
  font-weight: bold;
  padding: .5em 0 0 1em;
  text-transform: uppercase;
}
.cart .items .cartSection p.stockStatus.out {
  color: #F69679;
}
.cart .items .cartSection .itemImg {
  width: 4em;
  float: left;
}
.cart .items .cartSection.qtyWrap, .cart .items .cartSection.prodTotal {
  text-align: center;
}
.cart .items .cartSection.qtyWrap p, .cart .items .cartSection.prodTotal p {
  font-weight: bold;
  font-size: 1.25em;
}
.cart .items .cartSection input.qty {
  width: 2em;
  text-align: center;
  font-size: 1em;
  padding: .25em;
  margin: 1em .5em 0 0;
}
.cart .items .cartSection .itemImg {
  width: 8em;
  display: inline;
  padding-right: 1em;
}

.special {
  display: block;
  /* font-family: "Montserrat", sans-serif; */
}
.special .specialContent {
  padding: 1em 1em 0;
  display: block;
  margin-top: .5em;
  border-top: 1px solid #dadada;
}
.special .specialContent:before {
  content: "\21b3";
  font-size: 1.5em;
  margin-right: 1em;
  color: #6f6f6f;
  /* font-family: helvetica, arial, sans-serif; */
}

a.remove {
  text-decoration: none;
  /* font-family: "Montserrat", sans-serif; */
  color: #ffffff;
  font-weight: bold;
  background: #e0e0e0;
  padding: .5em;
  font-size: .75em;
  display: inline-block;
  border-radius: 100%;
  line-height: .85;
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  -ms-transition: all 0.25s linear;
  -o-transition: all 0.25s linear;
  transition: all 0.25s linear;
}
a.remove:hover {
  background: #f30;
}

.promoCode {
  border: 2px solid #efefef;
  float: left;
  width: 35%;
  padding: 2%;
}
.promoCode label {
  display: block;
  width: 100%;
  font-style: italic;
  font-size: 1.15em;
  margin-bottom: .5em;
  letter-spacing: -.025em;
}
.promoCode input {
  width: 85%;
  font-size: 1em;
  padding: .5em;
  float: left;
  border: 1px solid #dadada;
}
.promoCode input:active, .promoCode input:focus {
  outline: 0;
}
.promoCode a.btn {
  float: left;
  width: 15%;
  padding: .75em 0;
  border-radius: 0 1em 1em 0;
  text-align: center;
  border: 1px solid #82ca9c;
}
.promoCode a.btn:hover {
  border: 1px solid #f69679;
  background: #f69679;
}

.btn:link, .btn:visited {
  text-decoration: none;
  /* font-family: "Montserrat", sans-serif; */
  letter-spacing: -.015em;
  font-size: 1em;
  padding: 1em 3em;
  color: #fff;
  background: #82ca9c;
  font-weight: bold;
  border-radius: 50px;
  float: right;
  text-align: right;
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  -ms-transition: all 0.25s linear;
  -o-transition: all 0.25s linear;
  transition: all 0.25s linear;
}
.btn:after {
  content: "\276f";
  padding: .5em;
  position: relative;
  right: 0;
  -webkit-transition: all 0.15s linear;
  -moz-transition: all 0.15s linear;
  -ms-transition: all 0.15s linear;
  -o-transition: all 0.15s linear;
  transition: all 0.15s linear;
}
.btn:hover, .btn:focus, .btn:active {
  background: #f69679;
}
.btn:hover:after, .btn:focus:after, .btn:active:after {
  right: -10px;
}
.promoCode .btn {
  font-size: .85em;
  paddding: .5em 2em;
}

/* TOTAL AND CHECKOUT  */
.subtotal {
  float: right;
  width: 35%;
}
.subtotal .totalRow {
  padding: .5em;
  text-align: right;
}
.subtotal .totalRow.final {
  font-size: 1.25em;
  font-weight: bold;
}
.subtotal .totalRow span {
  display: inline-block;
  padding: 0 0 0 1em;
  text-align: right;
}
.subtotal .totalRow .label {
  /* font-family: "Montserrat", sans-serif; */
  font-size: .85em;
  text-transform: uppercase;
  /* color: #777; */
}
.subtotal .totalRow .value {
  letter-spacing: -.025em;
  width: 35%;
}

@media only screen and (max-width: 39.375em) {
  .wrap {
    width: 98%;
    padding: 2% 0;
  }

  .projTitle {
    font-size: 1.5em;
    padding: 10% 5%;
  }

  .heading {
    padding: 1em;
    font-size: 90%;
  }

  .cart .items .cartSection {
    width: 90%;
    display: block;
    float: left;
  }
  .cart .items .cartSection.qtyWrap {
    width: 10%;
    text-align: center;
    padding: .5em 0;
    float: right;
  }
  .cart .items .cartSection.qtyWrap:before {
    content: "QTY";
    display: block;
    /* font-family: "Montserrat", sans-serif; */
    padding: .25em;
    font-size: .75em;
  }
  .cart .items .cartSection.prodTotal, .cart .items .cartSection.removeWrap {
    display: none;
  }
  .cart .items .cartSection .itemImg {
    width: 25%;
  }

  .promoCode, .subtotal {
    width: 100%;
  }

  a.btn.continue {
    width: 100%;
    text-align: center;
  }
}
</style>
@endsection

@section('content')
<div class="wrap cf">
  <h1 class="projTitle">Shopping Cart</h1>
  <div class="heading cf">
    <h1>My Cart</h1>
    <a href="/" class="continue">Continue Shopping</a>
  </div>
  @isset($sidedish_list)
  <div class="cart">
    <ul class="cartWrap" style="padding-left:0;">
    <div id="meat_list_data" data-field-id="{{ json_encode($meat_list)}})"></div>
    <div id="sidedish_list_data" data-field-id="{{json_encode($sidedish_list)}}"></div>
    @foreach($sidedish_list as $meatid => $sidedishes)
      <li class="items odd">
        
    <div class="infoWrap"> 
        <div class="cartSection">
        <img src="{{ asset("/images/". $meat_list[$meatid]->image . "." . $meat_list[$meatid]->image_type)}}" alt="{{ ucwords($meat_list[$meatid]->name)}}" class="itemImg" />
          {{--<!-- <p class="itemNumber">#QUE-007544-002</p> -->--}}
          <h5 class="mb-0">{{$meat_list[$meatid]->name}} <small><i><a href=# id="meat_qty_{{$meat_list[$meatid]->id}}" style="color:red">remove</a></i></small></h5>
           <p class="mb-0"> <input type="text"  class="qty"  value="{{$meat_list[$meatid]->order}}" disabled/> x &#x20B1;{{number_format($meat_list[$meatid]->unit_price,2)}}</p>
        
         {{-- <!-- <p class="stockStatus"> In Stock</p> -->--}}
        </div>  
    
         
      </div>
      @isset($sidedish_list[$meatid])
      @foreach($sidedishes as $sidedishid => $sidedish)
      @if($sidedish != (object)array())
      <ul class="cartWrap" style="padding-left:0;">
        <li class="items odd">
            <div class="infoWrap"> 
                <div class="cartSection">
                <img src="{{ asset("/images/". $sidedish_list[$meatid][$sidedishid]->image . "." . $sidedish_list[$meatid][$sidedishid]->image_type)}}" alt="{{ ucwords($sidedish_list[$meatid][$sidedishid]->name)}}" class="itemImg" />
                <!-- <p class="itemNumber">#QUE-007544-002</p> -->
                <h5>{{$sidedish_list[$meatid][$sidedishid]->name}} <small><i><a href=# id="sidedish_qty_{{$meatid}}_{{$sidedish_list[$meatid][$sidedishid]->id}}" style="color:red">remove</a></i></small></h5>
                <p> <input type="text" class="qty"  value="{{$sidedish_list[$meatid][$sidedishid]->order}}" disabled/> x &#x20B1;{{number_format($sidedish_list[$meatid][$sidedishid]->unit_price,2)}}</p>
                
                <!-- <p class="stockStatus"> In Stock</p> -->
                </div>  
            
                
                <!-- <div class="prodTotal cartSection">
                <p>$15.00</p>
                </div>
                    <div class="cartSection removeWrap">
                <a href="#" class="remove">x</a>
                </div> -->
            </div>

        </li>
      </ul>
      @endif
      @endforeach
      @endisset()
      </li>
      @endforeach
      
       
    </ul>
  </div>
  
  <div class="subtotal cf">
    <ul>
      <!-- <li class="totalRow"><span class="label">Subtotal</span><span class="value">$35.00</span></li> -->
      
          <!-- <li class="totalRow"><span class="label">Shipping</span><span class="value">$5.00</span></li> -->
      
            <!-- <li class="totalRow"><span class="label">Tax</span><span class="value">$4.00</span></li> -->
            
            <li class="totalRow final"><span class="label">Total</span><span class="value">&#x20B1;{{number_format($total_order,2)}}</span></li>
            @if(!isset($calendar_capacity))
            <li class="totalRow">
            <div class="text-center">
            <strong>ATTENTION</strong> <i class="fa fa-exclamation-triangle" style="color:#b50e35"></i>  
            </div>
            <div id="calendar_capacity" data-field-id="{{ \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}"></div>
            <div class="col-12 text-center pb-2">
                Due to the high-demand of Sunday Smoker BBQs,
                the next date we can deliver will be on 
                <u>{{ \Carbon\Carbon::now()->addDays(1)->format('F d, Y') }}</u>
            </div>
            </li>
            @endif
            <li class="totalRow">
            <div class="text-center">
                To continue to order, tap on Checkout below
                or Select a <strong><span style="color:blue"><u>Different Date</u></span></strong>
                <input placeholder="Selected date" type="text" style="text-align:center;" class="form-control datepicker">
            </div>
            </li>
      <li class="totalRow"><a href="#" id="submitOrder" class="btn continue">Checkout</a></li>
    </ul>
  </div>
  @endisset
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
            labelCounter += parseInt(orders.meat[value])
            for(let value2 in sidedish[value]) {
            labelCounter += parseInt(sidedish[value][value2])
            }      
        }
        return labelCounter;
    }

if(parseFoodList != null) {
  for(let meatid in parseFoodList.meat) {
    $('#meat_qty_'+meatid).on('click', function() {
      delete parseFoodList.meat[meatid];
      delete parseFoodList.sidedish[meatid];
      sessionStorage.setItem("FOOD_LIST", JSON.stringify(parseFoodList));
      let newSessionFoodList = sessionStorage.getItem("FOOD_LIST");
      sessionStorage.setItem('CART_COUNT', countOrders(parseFoodList))
      $.post( "{{url('cart')}}",{_token: "{{ csrf_token() }}", cart_data: newSessionFoodList}, function( data ) {
        $('html').html( data );
      });
    })

    for(let sidedishid in parseFoodList.sidedish[meatid]) {
      $('#sidedish_qty_'+meatid+'_'+sidedishid).on('click', function() {
        parseFoodList.sidedish[meatid][sidedishid] = 0;
        sessionStorage.setItem("FOOD_LIST", JSON.stringify(parseFoodList));
        let newSessionFoodList = sessionStorage.getItem("FOOD_LIST");
        sessionStorage.setItem('CART_COUNT', countOrders(parseFoodList))
        $.post( "{{url('cart')}}",{_token: "{{ csrf_token() }}", cart_data: newSessionFoodList}, function( data ) {
          $('html').html( data );
        });
      })
    }
   
  }
}


  let capacity_date = $('#calendar_capacity').length == 0 ? moment().format("YYYY-MM-DD") : $('#calendar_capacity').data("field-id");    
   
    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "up",
        minDate: moment(capacity_date).format("MMMM DD, YYYY"),
        applyButtonClasses: "btn-warning",
        // autoApply: true,
        locale: {
            format: "MMMM DD, YYYY",
            applyLabel: "Confirm",
        },
    }, function(start, end, label) {
        capacity_date = start.format('YYYY-MM-DD');

        $.post( "{{ url('order/validation') }}", {
        _token: "{{ csrf_token() }}", 
        cart_data: sessionFoodList, 
        date: capacity_date
    }).done(function( data ) {
      
        if(data.error) {
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
        }else {
          sessionStorage.setItem('CAPACITY_DATE', JSON.stringify(capacity_date));
        }
      });
        
        // console.log("A new date selection was made: "+ label+ ' ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });

  $('#submitOrder').on('click', function() {
    $.post( "{{ url('order/validation') }}", {
        _token: "{{ csrf_token() }}", 
        cart_data: sessionFoodList, 
        date: capacity_date
    }).done(function( data ) {
      
        if(data.error) {
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
        }else {
          sessionStorage.setItem('CAPACITY_DATE', JSON.stringify(capacity_date));
          window.location.href = "{{url('/payment')}}"
        }
      });

  })

    
});
</script>
@endpush