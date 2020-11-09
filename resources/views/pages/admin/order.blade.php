@extends('admin')

@section('custom_style')
<style>
.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}
.modal-content {
  top: 30vh;
}

</style>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/admin/order">Order</a></li>
      </ol>
    </nav>
<div class="alert alert-success successText" style="display:none">
    Success
</div>
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
      <th><a href="/admin/order/details/{{$order->id}}" style="color:#b50e35;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
      <td><small>{{ \Carbon\Carbon::parse($order->created_at)->format('m-d-Y') }}</small></td>
      <td>{{$order->fname}}</td>
      <td>{{$order->lname}}</td>
      <td>{{ $order->status == 1 ? 'Yes' : 'No' }}</td>
      <td>{{ number_format($order->delivery_fee,2)}}</td>
      <td>{{ number_format($order->total_price,2)}}</td>
      <td><a data-toggle="modal" data-target="#deleteModal{{$order->id}}" style="color:#b50e35;"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
    </tr>
    <div class="modal fade" id="deleteModal{{$order->id}}" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-body">
            <p style="text-align:center">ARE YOU SURE?</p>
          </div>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" id="{{$order->id}}" class="btn btn-danger deleteItem" data-dismiss="modal">Delete</button>
        </div>
        
      </div>
    </div>

  @endforeach
  </tbody>
</table>
</div>
{{ $orders->links() }}
</div>
@endsection

@push('scripts')
<script>
$( document ).ready(function() {
  $.ajaxSetup({
    headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}",
        }
    });
  $('.deleteItem').on('click', function() {
    
    $.ajax( {
            type: "DELETE",
            url: "{{ url('admin/order/')}}"+ '/' + this.id,
            success: function(data) {
                if(data.status) {
                    location.reload();
                    $('.successText').show();
                    setTimeout(function(){ $('.successText').fadeOut() }, 2000);
                }
            }
        });
  })
    
});
</script>
@endpush