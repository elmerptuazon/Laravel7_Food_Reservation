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
<div class="container container-remove-padding">
<div style="overflow: auto;">
<table class="table">
  <thead class="thead">
    <tr>
      <th scope="col"><small>Food</small></th>
      <th scope="col"><small>Order From</small></th>
      <th scope="col"><small>Qty</small></th>
      <th scope="col"><small>Delivery Fee(<span>&#x20B1;</span>)</small></th>
      <th scope="col"><small>Total Price(<span>&#x20B1;</span>)</small></th>
    </tr>
  </thead>
  <tbody>
  @foreach($orderitems as $orderitem)
  <tr>
      <td><small>{{ ucwords($orderitem->foodname) }}</small></td>
      <td><small>{{ ucwords($orderitem->order->fname) }} {{ucwords($orderitem->order->lname)}}</small></td>
      <td>{{ $orderitem->quantity }}</td>
      <td><small>{{ number_format($orderitem->order->delivery_fee,2) }}</small></td>
      <td><small>{{ number_format($orderitem->order->total_price,2) }}</small></td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
{{ $orderitems->links() }}
</div>
@endsection