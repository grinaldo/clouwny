 @extends('layouts.master')

@section('page-title')
Clouwny | My Order
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center>
                    <h3>Terima Kasih</h3>
                </center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col m6 s12">
                <center class="text-center">
                    <img width="300" src="{{ asset('images/box.png') }}" alt="">
                    <br>
                    <p class="grey-text">
                        <b>Order Anda akan diposes dan dikirimkan dalam waktu 1x24 setelah pembayaran dikonfirmasi. (Waktu pengiriman: Senin-Jumat: 10:00-17:00 / Sabtu 10:00-14:00)</b>
                        <br>
                        <small class="red-text">NO DELIVERY on Sunday and public holidays</small>
                    </p>
                </center>
            </div>
            <div class="col m6 s12">
                <h4>Detil Transaksi</h4>
                <p>
                    Transaksi Anda adalah sebagai berikut: 
                    <br>
                    @if(!empty($promo_code))
                    <b class="blue-text">Kode Promo: </b>{{ $promo_code ?? "-" }}
                    <br>
                    <b class="blue-text">Potongan:  </b>Rp. {{ number_format($deduction) }},-
                    <br>
                    @endif
                    <b class="green-text">Total Bayar: </b><b><span class="blue-text">Rp. {{ number_format($totalFee) }},-</span></b>
                    <br>
                    <small class="pink-text">Silahkan lakukan pembayaran dalam waktu 1x24 jam untuk Kami verifikasi dan lanjutkan dengan proses pengiriman barang</small>
                    <div class="divider"></div>
                    <br>
                    <a class="btn-uniform" href="{{ route('products') }}">Lanjutkan Belanja</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection