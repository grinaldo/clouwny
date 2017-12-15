@extends('layouts.master')

@section('page-title')
Clouwny | Home Page
@endsection

@section('content')
<section>
    <div class="no-pad-bot" id="index-banner">
        <div class="home_hero__slider">
            @if(!count($banners))
            <div class="wide-container">
                <div class="row hero-relative__container no-space">
                    <div class="col m6">
                    </div> 
                    <div class="col s6 bg-pink">
                    </div>
                    <div class="hero-relative" style="background: url({{ asset('images/banner-lg-2.jpg') }}) center no-repeat; ">
                        <h3 class="hero-relative__heading">My Style</h3>
                        <p class="hero-relative__description">A new beginning. A fresh breath of spring to soothe my mind. Keeping me to go around and around in fashionably way.</p>
                    </div>
                </div>
            </div>
            @else
            @foreach($banners as $banner)
            <div class="wide-container">
                <div class="row hero-relative__container no-space">
                    <div class="col m6">
                    </div> 
                    <div class="col s6 bg-pink">
                    </div>
                    <div class="hero-relative" style="background: url({{ asset($banner->image) }}) center no-repeat; ">
                        <h3 class="hero-relative__heading">{{ $banner->name }}</h3>
                        <p class="hero-relative__description">{{ $banner->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

@if(count($categories))
<section>
    <div class="row category-container">
        @foreach($categories as $key => $category)
        <a href="{{ url('products/'.$category->slug) }}">
            <div class="col s{{ceil(12/count($categories))}}" style="background: url('{{ empty($categories->image) ? asset('images/category-'.($key+1).'.jpg') : asset($category->image)}}');">
                <div class="category-container__description">{{ $category->name }}</div>
            </div>
        </a>
        @endforeach
        {{-- <a href="">
            <div class="col m3 s6" style="background: url('{{ asset('images/category-2.jpg') }}');">
                <div class="category-container__description">Category 2</div>
            </div>
        </a>
        <a href="">
            <div class="col m3 s6" style="background: url('{{ asset('images/category-3.jpg') }}');">
                <div class="category-container__description">Category 3</div>
            </div>
        </a>
        <a href="">
            <div class="col m3 s6" style="background: url('{{ asset('images/category-4.jpg') }}');">
                <div class="category-container__description">Category 4</div>
            </div>
        </a> --}}
    </div>
    <div class="row">
        <div class="col s12">
            <p>
                <center>
                    <a href="" class="btn-uniform">All Collections</a>
                </center>
            </p>
        </div>
    </div>
</section>
@endif

{{-- <section class="no-pad-bot bg-grey">
    <div class="container cover-width pad-vertical-hero">
        <div class="flex-container promo-container">
            <div class="aligner-item aligner-item--bottom">
                <div class="collection-card promo-card">
                    <a href="">
                        <img src="{{ asset('images/hot-1.jpg') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="aligner-item">
                <div class="collection-card promo-card">
                    <a href="">
                        <img src="{{ asset('images/hot-2.jpg') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="aligner-item aligner-item--top">
                <div class="collection-card promo-card">
                    <a href="">
                        <img src="{{ asset('images/hot-3.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="promo-text__heading">
                <h3>HOT</h3>
            </div>
            <div class="promo-text__description">
                <b>KISS - Keep it Simple and Sassy. Because simple is the new beauty and beauty is every girl's privilege.</b>
            </div>
        </div>
    </div>
</section> --}}

{{-- <section class="artist-slider">
    <div class="container">
        <div class="row">
            <div class="col m8 s12">
                <div class="artist-slider__slider">
                    <div><img src="{{ asset('images/slider-square-0.jpg') }}" alt=""></div>
                    <div><img src="{{ asset('images/slider-square-1.jpg') }}" alt=""></div>
                    <div><img src="{{ asset('images/slider-square-2.jpg') }}" alt=""></div>
                    <div><img src="{{ asset('images/slider-square-3.jpg') }}" alt=""></div>
                </div>
            </div>
            <div class="col m4 s12">
                <h2>Our Loved Fashionista</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque asperiores ipsum odit soluta, architecto, eaque consequuntur optio, magni necessitatibus tenetur vel, nobis esse minus! Reiciendis natus, excepturi ipsum accusantium repellendus.</p>
            </div>
        </div>
    </div>
</section> --}}

@if(count($products))
<section class="section bg-light-grey">
    <div class="container">
        <div class="row">
            <h3>Featured</h3>
        </div>
        <div class="row product-container">
            @foreach($products as $product)
            <div class="col m4 s12 product-card">
                <a href="{{ url('products/'.$product->category()->first()->slug.'/'.$product->slug) }}">
                    <div class="product-card__image-container">
                        <img src="{{ asset(!empty($product->image)?$product->image:'images/product-1.jpg') }}" alt="">
                        <img src="{{ asset(!empty($product->images()->first())?$product->images()->first()->image:'images/product-2.jpg') }}" alt="">
                    </div>
                    <div class="product-card__description">
                        <b>Product Title: </b> Rp 1.000.000
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(!empty($static))
<section class="section">
    <div class="row about-container">
        <div class="col s4 about-container__heading">
            <a href="{{ route('products') }}" class="button-box button-bar">
                Check our collection
                <i class="fa fa-icon fa-arrow-right"></i>
            </a>
            {!! $static->title !!}
        </div>
        <div class="col s8 about-container__description">
            <div class="about-container__description-content">
                <h5>{{ $static->short_title }}</h5>
                <br>
                <p>{!! $static->description !!}</p>
            </div>
            <img class="about-container__description-image" src="{{ asset('images/banner-lg-1.jpg') }}" alt="">
        </div>
    </div>
</section>
@endif

@endsection

@section('page-script')
@endsection