@extends('layouts.master')

@section('page-title')
Clouwny | About Us
@endsection

@section('content')
<section>
    <div class="row product-banner" style="background: url({{ !empty($about) && !empty($about->image) ? asset($about->image) : asset('images/about.jpg') }}) no-repeat center;">
        <div class="col m4 s6"></div>
        <div class="col m8 s12 product-banner__description">
            <h3>Tentang Kami</h3>
            <p>Clouwny online clothing store</p>
        </div>
    </div>
</section>
<section class="section">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col s12 m12">
                <h3>Clouwny Online Store</h3>
                @if(!empty($about->description))
                <p>{{$about->description}}</p>
                @else
                <p>Here in <b>Clouwny</b> we provide the high quality women wears with interesting price for you fashion lovers. We have wide range of collections from dressing, accessories, and so on to fulfill your fashion needs. </p>
                @endif
            </div>
            <div class="divider"></div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection