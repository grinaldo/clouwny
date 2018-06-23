@extends('layouts.master')

@section('page-title')
Clouwny | Product - {{ $product->name }}
@endsection

@section('content')
<section class="section">
    <div class="container">
        <div class="row product-detail">
            <div class="col s12 m3 product-detail__left">
                <div class="divider"></div>
                <h4 class="product-detail__name">{{ $product->name }}</h4>
                <br>
                <div class="divider"></div>
                {{-- <p class="product-detail__addinfo">
                    <b>Price: Rp {{ number_format($product->price) }}</b>
                    <br>
                    <b>Stock: {{ number_format($product->stock) }}</b>
                </p> --}}
                <div class="divider"></div>
                <br>
                {!! Form::open([
                        'route'  => 'cart.store',
                        'method' => 'POST'
                    ])
                !!}
                    @if($product->stock !== 0)
                    <div class="row">
                        <div class="col s12">
                            @if(!empty($product->discounted_price) && $product->discounted_price > 0)
                            <b>
                                <small class="red-text" style="text-decoration: line-through">Harga: Rp {{ number_format($product->price) }}</small>
                            </b>
                            <br>
                            <b>Harga: Rp {{ number_format($product->discounted_price) }}</b>
                            @else
                            <b>Harga: Rp {{ number_format($product->price) }}</b>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="input-field">
                        {!! Form::select('variant', $variants) !!}
                        <label for="variant">Variant</label>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <input placeholder="Quantity" id="quantity" type="text" class="validate" style="border-bottom: 1px solid #aaa" name="quantity" value="1">
                                <label for="quantity">Quantity</label>
                            </div>
                        </div>
                        {{-- <div class="col s6">
                            <div class="input-field">
                                {!! Form::select('size', ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL']) !!}
                                <label for="size">Size</label>
                            </div>
                        </div> --}}
                    </div>
                    @endif
                    @if($product->stock == 0)
                    <p><b>-- Out of Stock --</b></p>
                    @endif
                    <button class="button-box button-foo favorite-btn" data-product="{{ $product->slug }}"><b><i class="fa fa-icon fa-heart"></i></b></button>
                    {!! Form::hidden('product', $product->slug) !!}
                    @if ($product->stock !== 0)
                    <button class="button-box button-foo" type="submit"><b>Add to Cart</b></button>
                    @endif
                {!! Form::close() !!}
            </div>
            <div class="col s12 m6 product-detail__mid">
                <div class="carousel carousel-slider" data-indicators="true">
                    <a class="carousel-item" href="#main">
                        <img src="{{ !empty($product->image) ? asset($product->image) : asset('images/product-1.jpg') }}">
                    </a>
                    @if(count($product->images()->get()))
                    @foreach($product->images()->get() as $key => $image)
                    <a class="carousel-item" href="#{{$key}}">
                        <img src="{{ !empty($image->image) ? asset($image->image) : asset('images/product-1.jpg') }}">
                    </a>
                    @endforeach
                    @endif
                </div>

                {{-- <div class="product-detail__image-container">
                    <img src="{{ !empty($product->image) ? asset($product->image) : asset('images/product-1.jpg') }}" alt="">
                </div>
                <div class="product-detail__image-slider-container">
                    <ul>
                        <li><img src="{{ asset('images/product-2.jpg') }}" alt=""></li>
                        <li><img src="{{ asset('images/product-2.jpg') }}" alt=""></li>
                    </ul>
                </div> --}}
            </div>
            <div class="col s12 m3 product-detail__right">
                <div class="divider"></div>
                <h5>Details</h5>
                {{-- <p class="product-detail__addinfo">
                    <br>
                    <b>Stock: {{ number_format($product->stock) }}</b>
                </p>
                <div class="divider"></div> --}}
                {!! $product->description !!}
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
<script>
$(document).ready(function(){
    $('.carousel').carousel({
        fullWidth: true,
        indicators: true,
        duration: 200
    });
    autoplay();
    function autoplay() {
        $('.carousel').carousel('next');
        setTimeout(autoplay, 3000);
    }
});
</script>
@endsection