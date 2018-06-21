@extends('layouts.master')

@section('page-title')
Clouwny | Belanjaanku
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center><h2>Akun Saya</h2></center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                @include('_includes._profile-navigation')
                <div id="cart" class="col s12">
                    <h4 class="grey-text">Belanjaan Saya</h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Item</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($carts) && count($carts))
                            @if(\Auth::check())
                            @foreach($carts as $key => $item)
                            <tr class="idx-cart-{{$key}}">
                                <td><img src="{{ !empty($item->product()->first()->image) ? asset($item->product()->first()->image) : asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>
                                    <a class="grey-text" href="{{ url('/products/'.$item->product()->first()->category()->first()->slug.'/'.$item->product()->first()->slug) }}">
                                        {{ $item->product()->first()->name }}
                                        - <i class="fa fa-icon fa-search"></i>
                                    </a>
                                    <br>
                                    @if(!empty($item->productVariant()->first()))
                                    <span class="blue-text">{{ $item->productVariant()->first()->name }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->amount }}</td>
                                <td>
                                    @if(!empty($item->product()->first()->discounted_price) && $item->product()->first()->discounted_price > 0)
                                    Rp {{ number_format($item->product()->first()->discounted_price) }},-
                                    <br>
                                    <b>
                                        <small class="red-text"  style="text-decoration: line-through">
                                            Rp {{ number_format($item->product()->first()->price) }},-
                                        </small>
                                    </b>
                                    @else
                                    Rp {{ number_format($item->product()->first()->price) }},-
                                    @endif
                                </td>
                                <td><button class="btn-uniform rm-cart-btn" type="submit" data-product="{{ $item->product()->first()->slug }}" data-target=".idx-cart-{{$key}}"><i class="fa fa-icon fa-close" title="remove" alt="remove"></i></button></td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($carts as $key => $item)
                            <tr class="idx-cart-{{$key}}">
                                <td><img src="{{ !empty($item['product']->image) ? asset($item['product']->image) : asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>
                                    <a class="grey-text" href="{{ url('/products/'.$item['product']->category()->first()->slug.'/'.$item['product']->slug) }}">
                                        {{ $item['product']->name }}
                                        - <i class="fa fa-icon fa-search"></i>
                                    </a>
                                </td>
                                <td>{{ $item['quantity'] }}</td>
                                @if(!empty($item['product']->discounted_price) && $item['product']->discounted_price > 0)
                                <td>Rp {{ number_format($item['product']->discounted_price) }},-</td>
                                @else
                                <td>Rp {{ number_format($item['product']->price) }},-</td>
                                @endif
                                <td><button class="btn-uniform rm-cart-btn" type="submit" data-product="{{ $item['product']->slug }}" data-target=".idx-cart-{{$key}}"><i class="fa fa-icon fa-close" title="remove" alt="remove"></i></button></td>
                            </tr>
                            @endforeach
                            @endif

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