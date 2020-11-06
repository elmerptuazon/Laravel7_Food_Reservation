@extends('index')

@section('custom_style')
<style>

.product-grid6,.product-grid6 .product-image6{overflow:hidden}
.product-grid6{font-family:'Open Sans',sans-serif;text-align:center;position:relative;transition:all .5s ease 0s}
.product-grid6 .product-image6 a{display:block}
.product-grid6 .product-image6 img{width:100%;height: 200px;transition:all .5s ease 0s}
.product-grid6:hover .product-image6 img{transform:scale(1.1)}
.product-grid6 .product-content{padding:12px 12px 15px;transition:all .5s ease 0s}
.product-grid6 .title{font-size:20px;font-weight:600;text-transform:capitalize;margin:0 0 10px;transition:all .3s ease 0s}
.product-grid6 .title a{color:#000}
/* .product-grid6 .title a:hover{color:#2e86de} */
.product-grid6 .price{font-size:18px;font-weight:600;color:#2e86de}
.product-grid6 .price span{color:#999;font-size:15px;font-weight:400;text-decoration:line-through;margin-left:7px;display:inline-block}

@media only screen and (max-width:990px){.product-grid6{margin-bottom:30px}
}

.col-md-3.col-sm-6 {
    padding-right: 0;
    padding-left: 0;
}
</style>
@endsection

@section('content')


<div class="container">
    <div class="row">
        @foreach($food as $val)
        <div class="col-md-3 col-sm-6">
            <div class="product-grid6 mb-0">
                <div class="product-image6">
                    <a href="/food/{{$val->id}}">
                        <!-- <img class="pic-1" src="http://bestjquery.com/tutorial/product-grid/demo10/images/img-1.jpg"> -->
                        <img class="pic-1" src="{{ asset("/images/". $val->image . "." . $val->image_type)}}" alt="{{ ucwords($val->name)}}">
                    </a>
                </div>
                <div class="product-content">
                    <small class="title"><a href="/food/{{$val->id}}">{{ ucwords($val->name)}}</a></small>
                    <div class="price">&#x20B1;{{ number_format($val->unit_price,2)}}
                        <span>&#x20B1;{{ number_format(($val->unit_price + rand(100,500)),2)}}</span>
                    </div>
                </div>
                {{--<ul class="social">
                    <li><a href="" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                    <li><a href="" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                    <li><a href="" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>--}}
            </div>
        </div>
        @endforeach
    </div>
</div>


@push('scripts')
<script>
$('[data-toggle="collapse"]').on('mouseenter', function() {
    $(this).parents('.card').find('.collapse').collapse('show');
});
</script>
@endpush

@endsection

