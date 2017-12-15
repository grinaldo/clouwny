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
                    <div class="input-field">
                        {!! Form::select('variant', $variants) !!}
                        <label for="variant">Variant</label>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div class="input-field">
                                <input placeholder="Quantity" id="quantity" type="text" class="validate" style="border-bottom: 1px solid #aaa" name="quantity">
                                <label for="quantity">Quantity</label>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field">
                                {!! Form::select('size', ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL']) !!}
                                <label for="size">Size</label>
                            </div>
                        </div>
                    </div>
                    <button class="button-box button-foo favorite-btn" data-product="{{ $product->slug }}"><b><i class="fa fa-icon fa-heart"></i></b></button>
                    {!! Form::hidden('product', $product->slug) !!}
                    <button class="button-box button-foo" type="submit"><b>Add to Cart</b></button>
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
                <p class="product-detail__addinfo">
                    <b>Price: Rp {{ number_format($product->price) }}</b>
                    <br>
                    <b>Stock: {{ number_format($product->stock) }}</b>
                </p>
                <div class="divider"></div>
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
        duration: 1
    });
});
</script>
@endsection