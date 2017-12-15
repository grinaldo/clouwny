@extends('layouts.master')

@section('page-title')
Clouwny |  My Wishlist
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center><h2>My Account</h2></center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                @include('_includes._profile-navigation')
                <div id="wishlist" class="col s12">
                    <h4 class="grey-text">My Wishlist</h4>
                     <table class="striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($products) && count($products))
                            @foreach($products as $key => $wishlist)
                            <tr class="idx-cart-{{$key}}">
                                <td><img src="{{ !empty($wishlist->product()->first()->image) ? asset($wishlist->product()->first()->image) : asset('images/dummy-1.jpg') }}" width="100" alt=""></td>
                                <td>
                                    <a class="grey-text" href="{{ url('/products/'.$wishlist->product()->first()->category()->first()->slug.'/'.$wishlist->product()->first()->slug) }}">
                                        {{ $wishlist->product()->first()->name }}
                                         - <i class="fa fa-icon fa-search"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                    <button class="btn-uniform cart-btn" data-product="{{ $wishlist->product()->first()->slug }}" data-amount="1" type="submit"><b>Add to Cart</b></button></a>
                                    <button class="btn-uniform rm-wishlist-btn" data-product="{{ $wishlist->product()->first()->slug }}" data-target=".idx-cart-{{$key}}">
                                        <b><i class="fa fa-icon fa-close" title="remove"></i></b>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3">No item on your wishlist</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection