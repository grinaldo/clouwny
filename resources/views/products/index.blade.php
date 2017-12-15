@extends('layouts.master')

@section('page-title')
Clouwny | All Collection
@endsection

@section('content')
<section>
    <div class="row product-banner" style="background: url({{ !empty($categorySelected) && !empty($categorySelected->image) ? asset($categorySelected->image) : asset('images/banner-med-4.jpg') }}) no-repeat center;">
        <div class="col m4 s6"></div>
        <div class="col m8 s12 product-banner__description">
            <h3>{{ empty($categorySelected)? 'Clouwny Collections' : $categorySelected->name }}</h3>
            <p>{{ empty($categorySelected)? 'A stylish women wear for fashionable lifestyle' : $categorySelected->short_description }}</p>
        </div>
    </div>
</section>
<section class="section">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col s12 m12">
                @if(empty($categorySelected))
                <h3>Clouwny Collections</h3>
                <p>Here in <b>Clouwny</b> we provide the high quality women wears with interesting price for you fashion lovers. We have wide range of collections from dressing, accessories, and so on to fulfill your fashion needs. </p>
                @else
                <h3>{{ $categorySelected->name }}</h3>
                <p>{{ $categorySelected->description }}</p>
                @endif
            </div>
            <div class="divider"></div>
        </div>
        <div class="row">
            <div class="col m2 s12">
                <div class="row">
                    <b>Our Collections</b>
                </div>
                <div class="row product-navigation">
                    <ul>
                        <li class="{{ empty($categorySelected->slug) ? 'selected' : '' }} no-mg">
                            <a class="{{ empty($categorySelected->slug) ? 'white-text' : '' }}" href="{{ route('products') }}">All Collections</a>
                        </li>
                        @foreach($allCategories as $category)
                        <li class="{{ !empty($categorySelected->slug) && $categorySelected->slug == $category->slug ? 'selected' : '' }} no-mg  ">
                            <a class="{{ !empty($categorySelected->slug) && $categorySelected->slug == $category->slug ? 'white-text' : '' }}" href="{{ url('products/'.$category->slug) }}">{{ $category->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col m10 s12 product-container">
                <div class="row no-mg">
                    <ul class="breadcrumb">
                        <li><a href="/"><i class="fa fa-icon fa-home inline-icon--1x"></i>Home</a></li>
                        <li><a href="{{ route('products') }}">Clouwny Collections</a></li>
                        @if(!empty($categorySelected))
                        <li><a href="{{ url('/products/'.$category->slug) }}">{{ $category->name }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="product-grid product-grid--flexbox no-mg">
                            <div class="product-grid__wrapper">
                                <!-- Product list start here -->
                                @foreach($products as $product)
                                <!-- Single product -->
                                <a href="{{ url('products/'.$product->category()->first()->slug.'/'.$product->slug) }}">
                                    <div class="product-grid__product-wrapper">
                                        <div class="product-grid__product">
                                            <div class="product-grid__img-wrapper">         
                                                <img src="{{asset($product->image)}}" alt="Img" class="product-grid__img" />
                                            </div>
                                            <span class="product-grid__title">{{ $product->name }}</span>
                                            <span class="product-grid__price">Rp. {{ number_format($product->price) }}</span>
                                            <div class="product-grid__extend-wrapper">
                                                <div class="product-grid__extend">
                                                    <p class="product-grid__description">{{ !empty($product->short_description) ? $product->short_description : 'Clouwny collection to brighten up your fashionable day' }}</p>
                                                    <span class="cart-btn product-grid__btn product-grid__add-to-cart" data-product="{{ $product->slug }}" data-amount="1">
                                                        <i class="fa fa-cart-arrow-down"></i> 
                                                        Add to cart
                                                    </span>

                                                    <a class="grey-text" href="{{ url('/products/'.$product->category()->first()->slug.'/'.$product->slug) }}">
                                                        <span class="product-grid__btn product-grid__view"><i class="fa fa-eye"></i>View</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- end Single product -->
                                @endforeach
                            </div>      
                        </div>
                        <center class="product-pagination">
                            {{ $products->render() }}
                        </center>
                    </div>
                </div>
                {{-- <div class="row">
                    @for($i=0; $i <12; $i++)
                    <div class="col m4 s6 product-card">
                        <a href="">
                            <div class="product-card__image-container">
                                <img src="{{ asset('images/product-1.jpg') }}" alt="">
                                <img src="{{ asset('images/product-2.jpg') }}" alt="">
                            </div>
                            <div class="product-card__description">
                                @if($i%2==0)
                                <b>Product Title </b> 
                                <br>Rp 1.000.000
                                @else
                                <b>Product Title with Longer Name until Reaches Two Lines </b> 
                                <br>Rp 1.000.000
                                @endif
                            </div>
                        </a>
                    </div>
                    @endfor
                </div> --}}
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection