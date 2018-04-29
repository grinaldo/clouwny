@if ($notif_success = Session::get(NOTIF_SUCCESS))
    @if($notif_success == 'Product has been added' || $notif_success == 'Successfully added to cart!')
    <div class="journey-box__container">
        <div class="journey-box">
            <p style="">
                Barang telah ditambahkan ke keranjang.
                @if($cart_added = Session::get('cart_added'))
                <br>
                {{ $cart_added[0] }} x {{ $cart_added[1] }}
                <br>
                <b>IDR {{ number_format($cart_added[2]) }},-</b>
                @endif
            </p>
            <div class="journey-box__shop-menu">
                <ul>
                    <li><a href="{{url('products')}}">Lanjutkan Belanja</a></li>
                    <li><a href="{{url('cart/checkout')}}">Checkout</a></li>
                </ul>
            </div>
        </div>
    </div>
    @else
    <div class="alert-box">
        <div class="alert alert-success">
            {{ $notif_success }}
            <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
        </div>
    </div>
    @endif
@endif
@if ($notif_info = Session::get(NOTIF_INFO))
<div class="alert-box">
    <div class="alert alert-info">
        {{ $notif_info }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
@if ($notif_warning = Session::get(NOTIF_WARNING))
<div class="alert-box">
    <div class="alert alert-warning">
        {{ $notif_warning }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
@if ($notif_danger = Session::get(NOTIF_DANGER))
<div class="alert-box">
    <div class="alert alert-danger">
        {{ $notif_danger }}
        <span class="close" onclick="$(this).parent().fadeOut();">&times;</span> 
    </div>
</div>
@endif
