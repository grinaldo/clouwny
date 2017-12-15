@extends('layouts.master')

@section('page-title')
Clouwny | Shopping Bag
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
                <div id="cart" class="col s12">
                    <h4 class="grey-text">My Shopping Bag</h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($carts) && count($carts))
                            @foreach($carts as $key=> $item)
                            <tr class="idx-cart-{{$key}}">
                                <td><img src="{{ !empty($item->image) ? asset($item->image) : asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>
                                    <a class="grey-text" href="{{ url('/products/'.$item->product()->first()->category()->first()->slug.'/'.$item->product()->first()->slug) }}">
                                        {{ $item->product()->first()->name }}
                                        - <i class="fa fa-icon fa-search"></i>
                                    </a>
                                </td>
                                <td>{{ $item->amount }}</td>
                                <td>Rp {{ number_format($item->product()->first()->price) }},-</td>
                                <td><button class="btn-uniform rm-cart-btn" type="submit" data-product="{{ $item->product()->first()->slug }}" data-target=".idx-cart-{{$key}}"><i class="fa fa-icon fa-close" title="remove" alt="remove"></i></button></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5"><b>No item added</b></td>
                            </tr>
                            @endif
                            @if(!empty($carts) && count($carts))
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th>{{ $qty }}</th>
                                    <th>Rp {{ number_format($totalPrice) }},-</th>
                                    <th>
                                        <a class="btn-uniform" href="{{ route('checkout') }}">Checkout</a>
                                    </th>
                                </tr>
                            </tfoot>
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