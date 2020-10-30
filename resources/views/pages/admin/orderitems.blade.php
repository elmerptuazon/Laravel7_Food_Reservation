@extends('admin')

@section('custom_style')
<style>
.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}

</style>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/calendar_capacity">Capacity/Inventory</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Order Items</a></li>
      </ol>
    </nav>
<div class="container container-remove-padding">
<div style="overflow: auto;">
<table class="table">
  <thead class="thead">
    <tr>
      <th scope="col"><small>Date<i>(mm-dd-yyyy)</i></small></th>
      <th scope="col"><small>Food</small></th>
      <th scope="col"><small>Order From</small></th>
      <th scope="col"><small>Qty</small></th>
      <th scope="col"><small>Delivery Fee(<span>&#x20B1;</span>)</small></th>
      <th scope="col"><small>Total Price(<span>&#x20B1;</span>)</small></th>
    </tr>
  </thead>
  <tbody>
  @foreach($orderitems as $orderitem)
  @isset($orderitem->order)
  <tr>
      <td><small>{{ \Carbon\Carbon::parse($orderitem->created_at)->format('m-d-Y') }}</small></td>
      <td><small>{{ ucwords($orderitem->foodname) }}</small></td>
      <td><small>{{ ucwords($orderitem->order->fname) }} {{ucwords($orderitem->order->lname)}}</small></td>
      <td>{{ $orderitem->quantity }}</td>
      <td><small>{{ number_format($orderitem->order->delivery_fee,2) }}</small></td>
      <td><small>{{ number_format($orderitem->order->total_price,2) }}</small></td>
    </tr>
  @endisset
  @endforeach
  </tbody>
</table>
</div>
{{ $orderitems->links() }}
</div>
@endsection