@extends('layouts.master')

@section('page-title')
Site Name | Checkout
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center><h2>Checkout</h2></center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col m6 s12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('checkout.order') }}">
                    {!! Form::hidden('total_price', $totalPrice) !!}
                    <h5 class="grey-text">Pembayaran</h5>
                    <div class="row">
                        <div id="delivery" class="col s12">
                            {{ csrf_field() }}
                            {{-- @if(!Auth::check()) 
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="guest_name" class="active">Nama Pembeli</label>   
                                    <input placeholder="Name" id="guest_name" type="text" class="validate form-site-input" name="guest_name" value="{{ !empty(old('guest_name')) ? old('guest_name') : '' }}">
                                </div>
                                <div class="input-field col m6 s6">
                                    <label for="guest_email" class="active">Email Pembeli</label>   
                                    <input placeholder="Email" id="guest_email" type="text" class="validate form-site-input" name="guest_email" value="{{ !empty(old('guest_email')) ? old('guest_email') : '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="guest_phone" class="active">Telpon Pembeli</label>   
                                    <input placeholder="Phone" id="guest_phone" type="text" class="validate form-site-input" name="guest_phone" value="{{ !empty(old('guest_phone')) ? old('guest_phone') : '' }}">
                                </div>
                                <div class="input-field col m6 s6">
                                    <label for="guest_confirmation" class="active">Channel Konfirmasi</label>   
                                    <input placeholder="Line @myline, Whatsapp, etc" id="guest_confirmation" type="text" class="validate form-site-input" name="guest_confirmation" value="{{ !empty(old('guest_confirmation')) ? old('guest_confirmation') : '' }}">
                                </div>
                            </div>
                            @endif --}}
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="receiver_name" class="active">
                                        Nama Penerima
                                        <span class="red-text">*</span>
                                    </label>   
                                    <input placeholder="Name" id="receiver_name" type="text" class="validate form-site-input" name="receiver_name" value="{{ !empty(old('receiver_name')) ? old('receiver_name') : ((Auth::check()) ? Auth::user()->name : '') }}">
                                </div>
                                <div class="input-field col s6">
                                    @if(Auth::check())
                                    {!! Form::select('payment_method', ['transfer' => 'Transfer', 'dompet' => 'Dompet'], '', ['id' => 'payment_method']) !!}
                                    @else 
                                    {!! Form::select('payment_method', ['transfer' => 'Transfer'], '', ['id' => 'payment_method']) !!}
                                    @endif
                                    <label>
                                        Pembayaran
                                        <span class="red-text">*</span>
                                    </label>
                                </div>
                                {!! Form::hidden('delivery_company', 'sicepat', ['id' => 'delivery_company']) !!}
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="receiver_phone" class="active">
                                        No. Telp
                                        <span class="red-text">*</span>
                                    </label>   
                                    <input placeholder="Phone" id="receiver_phone" type="text" class="validate form-site-input" name="receiver_phone" value="{{ !empty(old('receiver_phone')) ? old('receiver_phone') : ((Auth::check()) ? Auth::user()->phone : '') }}">
                                </div>
                                <div class="input-field col s6">
                                    {!! Form::email('receiver_email', (Auth::check()) ? Auth::user()->email : '') !!}
                                    <label>
                                        Email
                                        <span class="red-text">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="receiver_province" class="active">
                                        Provinsi
                                        <span class="red-text">*</span>
                                    </label>   
                                    {!! Form::select('receiver_province', $provinces, (\Auth::check()) ? \Auth::user()->province : '', ['id' => 'receiver_province']) !!}
                                </div>
                                <div class="input-field col m6 s6">
                                    <label for="receiver_city" id="receiver_city_label" class="active">Kota</label>   
                                    {!! Form::select('receiver_city', (\Auth::check()) ? [\Auth::user()->city => \Auth::user()->city] : ['-', '-'], '', ['id' => 'receiver_city']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="receiver_district" id="receiver_district_label" class="active">
                                        Kecamatan
                                        <span class="red-text">*</span>
                                    </label>   
                                    {!! Form::select('receiver_district', (\Auth::check()) ? $userDistrict : ['-', '-'], '', ['id' => 'receiver_district']) !!}
                                </div>
                                <div class="input-field col m6 s6">
                                    <label for="shipping_fee" id="shipping_fee_label" class="active">Jenis Pengiriman</label>   
                                    {!! Form::select('shipping_fee',  (\Auth::check()) ? $deliveryService : ['-', '-'], '', ['id' => 'shipping_fee']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="address">
                                        Alamat Lengkap
                                        <span class="red-text">*</span>
                                    </label>
                                    <textarea id="address" class="form-site-input materialize-textarea" name="receiver_address">{{ !empty(old('receiver_address')) ? old('receiver_address') : ((Auth::check()) ? Auth::user()->address : '') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="confirmation_account" class="active">
                                        Line id
                                    </label>   
                                    <input placeholder="line id" id="confirmation_account" type="text" class="validate form-site-input" name="{{ (Auth::check() ? 'confirmation_account' : 'guest_confirmation') }}" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <p>
                                        <input name="is_dropship" type="checkbox" class="filled-in" id="filled-in-box" "{{ old('is_dropship') ? 'checked' :'' }}" />
                                        <label for="filled-in-box">Dropship?</label>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m6 s6">
                                    <label for="shipper_name" class="active">Pengirim</label>   
                                    <input placeholder="Dropshipper Name" id="shipper_name" type="text" class="validate form-site-input" name="shipper_name" value="{{ old('shipper_name') }}">
                                </div>
                                <div class="input-field col m6 s6">
                                    <label for="shipper_phone" class="active">Telp. Pengirim</label>   
                                    <input placeholder="Dropshipper Phone" id="shipper_phone" type="text" class="validate form-site-input" name="shipper_phone" value="{{ old('shipper_phone') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="promo_code" class="active">
                                        Kode Promo
                                    </label>
                                    <input placeholder="Kode Promo" id="promo_code" type="text" class="validate form-site-input" name="promo_code" value="{{ !empty(old('promo_code')) ? old('promo_code') : '' }}">
                                    <div>
                                        <b>
                                            <small id="promo-info" class="promo-info blue-text"></small>
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn-uniform" type="submit"><b>Checkout</b></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col m6 s12">
                <h5 class="grey-text">Items</h5>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Weight (gr)</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($carts) && count($carts))
                        @if(Auth::check())
                        @foreach($carts as $key=> $item)
                        <tr class="idx-cart-{{$key}}">
                            <td><img src="{{ !empty($item->product()->first()->image) ? asset($item->product()->first()->image) : asset('images/dummy-2.jpg') }}" width="50" alt=""></td>
                            <td>{{ $item->product()->first()->name }}</td>
                            <td class="right-align">{{ $item->amount }}</td>
                            <td class="right-align">{{ number_format($item->product()->first()->weight) }}</td>
                            <td class="right-align">Rp {{ number_format($item->product()->first()->price) }},-</td>
                        </tr>
                        @endforeach

                        @else
                        @foreach($carts as $key => $item)
                        <tr class="idx-cart-{{$key}}">
                            <td><img src="{{ !empty($item['product']->image) ? asset($item['product']->image) : asset('images/dummy-2.jpg') }}" width="50" alt=""></td>
                            <td>{{ $item['product']->name }}</td>
                            <td class="right-align">{{ $item['quantity'] }}</td>
                            <td class="right-align">{{ number_format($item['product']->weight) }}</td>
                            <td class="right-align">Rp {{ number_format($item['product']->price) }},-</td>
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
                                <th class="right-align">{{ $qty }}</th>
                                <th class="right-align" id="totalweight" data-weight="{{ $totalWeight }}">{{ number_format($totalWeight) }} gr</th>
                                <th class="right-align">Rp {{ number_format($totalPrice) }},-</th>
                            </tr>
                        </tfoot>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="divider"></div>
        <br><br>
        <div class="row">
            <div class="col s12">
                <h5 class="grey-text">Payment Method</h5>
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s6"><a class="active" href="#transfer">Transfer</a></li>
                            <li class="tab col s6"><a href="#wallet">Wallet</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12" id="transfer">
                <h5 class="grey-text">Bank Transfer</h5>
                <p>This payment method will be verified by our admin once you've made the payment. Make sure that you have verified the transfer on our page after checkout ;).</p>
            </div>
            <div class="col s12" id="wallet">
                <h5 class="grey-text">Wallet Payment</h5>
                <p>Payment with wallet will automatically paid if your balance on your wallet is enough for payment. Make sure your wallet has the adequate balance for shopping ;).</p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
<script>
    $('select').material_select();
</script>
@endsection