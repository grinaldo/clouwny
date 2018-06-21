@extends('layouts.master')

@section('page-title')
Clouwny | Pesanan Saya
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
                <div id="order" class="col s12">
                    <h4 class="grey-text">Pesanan Saya</h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Nomor Pesanan</th>
                                <th>Status</th>
                                <th>Total Bayar</th>
                                <th>Tanggal Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($orders) && count($orders))
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->latest_status }}</td>
                                <td>
                                    Rp {{ number_format($order->total_fee) }},-
                                    <br>
                                    @if($order->promotion)
                                    <small>
                                        <span class="green-text"><b>kode promo: </b> {{ $order->promotion }}</span>
                                        <br>
                                        <span class="blue-text"><b>potongan: </b> {{ $order->deduction }}</span>
                                    </small>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ url('/orders/'.$order->id.'/detail') }}" class="btn-uniform" type="submit"><i class="fa fa-icon fa-search" title="detail"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">No orders</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <center class="product-pagination">
                {{ $orders->render() }}
            </center>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection