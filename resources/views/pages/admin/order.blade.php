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
      <th scope="col"></th>
      <th scope="col"><small>Date<i>(mm-dd-yyyy)</i></small></th>
      <th scope="col"><small>First Name</small></th>
      <th scope="col"><small>Last Name</small></th>
      <th scope="col"><small>Paid</small></th>
      <th scope="col"><small>Delivery Fee(<span>&#x20B1;</span>)</small></th>
      <th scope="col"><small>Total(<span>&#x20B1;</span>)</small></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($orders as $order)
  <tr>
      <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
      <td><small>{{ \Carbon\Carbon::parse($order->created_at)->format('m-d-Y') }}</small></td>
      <td>{{$order->fname}}</td>
      <td>{{$order->lname}}</td>
      <td>{{ $order->paymentid ? 'Yes' : 'No' }}</td>
      <td>{{ number_format($order->delivery_fee,2)}}</td>
      <td>{{ number_format($order->total_price,2)}}</td>
      <td><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
{{ $orders->links() }}
</div>
@endsection