@extends('index')

@section('content')
<div class="content-wrapper">
  <div class="card">
    <div class='card-block'>
      <div class='container  pt-5'>
        <h1 class='text-center text-success'>Thank you for purchasing!</h1>
        <hr>

        <div class='col-md-12'>

          @include('paypal.success_template')
          
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