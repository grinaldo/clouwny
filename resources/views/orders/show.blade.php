@extends('layouts.master')

@section('page-title')
Clouwny | Detil Order
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.min.css">
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
            <div class="col s12">
                <ul class="tabs" style="overflow: hidden !important">
                    <li class="tab col s4"><a class="active" href="#delivery">Info Pengiriman</a></li>
                    <li class="tab col s4"><a href="#status">Status</a></li>
                    <li class="tab col s4"><a href="#items">Item</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col s12" id="delivery">
                <h4>Info Pengiriman</h4>
                <h5 class="grey-text">Pesanan: # {{ $order->order_number }}</h5>
                <table class="striped">
                    <thead>
                        <tr>
                            <td colspan="2"><b>Info Kiriman</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>No. Resi: </b></td>
                            <td> {{ empty($order->tracking_number) ? '-' : $order->tracking_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Status Terakhir: </b></td>
                            <td> {{ $order->latest_status }}</td>
                        </tr>
                        <tr>
                            <td><b>Order Date: </b></td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <td><b>Jenis Pengiriman: </b></td>
                            <td>{{ $order->is_dropship ? 'Dropship' : 'normal' }}</td>
                        </tr>
                        <tr>
                            <td><b>Servis Pengiriman: </b></td>
                            <td>{{ $order->delivery_type }}</td>
                        </tr>
                        <tr>
                            <td><b>Info Pembayaran: </b></td>
                            <td>{{ $order->payment_method }}</td>
                        </tr>
                        <tr>
                            <td><b>Total Bayar</b></td>
                            <td>Rp. {{ number_format($order->total_fee) }},-</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="striped">
                    <thead>
                        <tr>
                            <th width="50%">Info Penerima</th>
                            <th width="50%">Info Pengirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Nama:</b> {{ $order->receiver_name }}</td>
                            <td><b>Nama:</b> {{ $order->is_dropship ? $order->shipper_name : '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Telp:</b> {{ $order->receiver_phone }}</td>
                            <td><b>Telp:</b> {{ $order->is_dropship ? $order->shipper_phone : '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Provinsi:</b> {{ $order->receiver_province }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Kota:</b> {{ $order->receiver_city }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Kecamatan:</b> {{ $order->receiver_district }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Kode Pos:</b> {{ $order->receiver_zipcode }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Alamat Lengkap:</b> {{ $order->receiver_address }}</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col s12" id="status">
                <div class="row">
                    <div class="col m6 s12">
                        <h4>Status</h4>
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            @foreach($order->statuses()->get() as $status)
                                <tr>
                                    <th>{{ $status->status }}</th>
                                    <th>{{ $status->created_at }}</th>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col m6 s12">
                        <h4>Konfirmasi Pembayaran</h4>
                        <p>Kontak Anda untuk konfirmasi</p>
                        {!! Form::open(['route' => 'orders.confirm', 'files' => true]) !!}
                            {!! Form::hidden('id', $order->id) !!}
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        {!! Form::select('confirmation_transfer', $banks, $order->payment_method) !!}
                                        <label for="Transfer Via">Metode Pembayaran</label>
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_payer" class="active">Rekening Pengirim</label>   
                                        <input placeholder="Nama pengirim (jika transfer bank)" id="confirmation_payer" type="text" class="validate form-site-input" name="confirmation_payer" value="{{ $order->confirmation_payer }}">
                                    <div class="input-field">
                                        <label for="confirmation_date" class="active">Tanggal Pembayaran</label>   
                                        <input placeholder="Tanggal Pembayaran" id="confirmation_date" type="text" class="validate form-site-input datepicker" name="confirmation_date" value="{{ $order->confirmation_date }}">
                                    </div>
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_channel" class="active">Media Konfirmasi</label>   
                                        {!! Form::select('confirmation_channel', ['Line' => 'Line', 'Whatsapp' => 'Whatsapp', 'Others' => 'Others'], $order->confirmation_account) !!}
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_account" class="active">Akun Konfirmasi</label>   
                                        <input placeholder="Akun Anda e.g: @my_line" id="confirmation_account" type="text" class="validate form-site-input" name="confirmation_account" value="{{ $order->confirmation_account }}">
                                    </div>

                                    <div class="input-field">
                                        <div class="file-field input-field">
                                            <div class="btn">
                                                <span>Unggah</span>
                                                <input type="file" name="confirmation_image">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" name="">
                                            </div>
                                        </div>
                                        @if(!empty($order->confirmation_image))
                                        <img style="width:50%" src="{{ asset($order->confirmation_image) }}" alt="">
                                        @endif
                                        <br>
                                        <small>Unggah bukti transfer Anda <span class="red-text">*</span></small>
                                    </div>

                                    <div class="input-field">
                                        <button class="btn-uniform" type="submit"><b>Confirm</b></button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col s12" id="items">
                <h4>Items</h4>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    @foreach($order->orderItems()->get() as $orderItem)
                        <tr>
                            <td><img width="100" src="{{ asset($orderItem->product()->first()->image) }}" alt=""></td>
                            <td>
                                {{ $orderItem->product()->first()->name }}
                                <br>
                                @if(!empty($orderItem->productVariant()->first()))
                                <span class="blue-text">{{ $orderItem->productVariant()->first()->name }}</span>
                                @endif
                            </td>
                            <td>Rp. {{ number_format($orderItem->sold_price) }},-</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
$('.datepicker').datepicker();
</script>
@endsection
