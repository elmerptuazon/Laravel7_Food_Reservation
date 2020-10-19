@extends('index')

@section('custom_style')
<style>
.relative {
  position: relative;
}

.sold-overlay {
position: absolute; 
bottom: 0; 
left: 25%;
width: 50%;
color: white;
font-size: 20px;
text-align:center;
}

img {
  max-width: 100% !important;
  max-height: 30vh !important;
  margin: auto;
}

.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}

.container .relative {
    transition: transform 330ms ease-in-out;
}

.container .relative .sold-overlay {
    transition: transform 330ms ease-in-out;
}

.container .relative:hover {
    transform: scaleY(1.3) rotate(0.01deg);
}

.container .relative:hover .sold-overlay {
    transform: translate(8px, -15vh);
}

</style>
@endsection

@section('content')
<div class="container container-remove-padding">

@foreach($food as $val)
    <div class="relative">
        <a href="/food/{{$val->id}}">
        <img src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" class="img-fluid" alt="{{ ucwords($val->name)}}" width="1000" height="auto">
        <div class="sold-overlay"><span style="color:white;" >{{ ucwords($val->name)}}</span></div>
        </a>
    </div>
@endforeach

</div>
@push('scripts')
<script>
$('[data-toggle="collapse"]').on('mouseenter', function() {
    $(this).parents('.card').find('.collapse').collapse('show');
});
</script>
@endpush

@endsection

