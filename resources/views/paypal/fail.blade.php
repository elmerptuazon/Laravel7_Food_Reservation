@extends('index')

@section('content')
<div class="content-wrapper">
  <div class="card">
    <div class='card-block'>
      <div class='container  pt-5'>
        <h1 class='text-center '>Your order has been cancelled.</h1>
        <hr>

        <div class='col-md-12'>
          <h5>Click <a href='/'>here</a> if you change your mind and want to order again</h5>

          <Br>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $( document ).ready(function() {
        
    });
</script>
@endpush