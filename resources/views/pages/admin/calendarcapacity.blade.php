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
      <th scope="col"><small>Capacity</small></th>
      <th scope="col"><small>Remaining</small></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($calendarcaps as $calendarcap)
  <tr>
    <th><i class="fa fa-pencil-square-o" aria-hidden="true"></i></th>
      <td><small>{{ \Carbon\Carbon::parse($calendarcap->from_date)->format('m-d-Y') }}</small></td>
      <td>{{$calendarcap->tray_capacity}}</td>
      <td><a href="order_items/{{$calendarcap->to_date}}">{{ $calendarcap->tray_remaining }}</a></td>
      <td><i class="fa fa-trash-o" aria-hidden="true"></i></td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
{{ $calendarcaps->links() }}
</div>
<div class="container">
    <div class="row">
        <div class="col-6 offset-3" style="display:grid;">
            <button type="button" class="btn btn-primary">CREATE</button>
        </div>
    </div>
</div>
@endsection