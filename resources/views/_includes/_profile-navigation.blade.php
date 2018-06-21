<div class="row">
    <div class="col s12">
        <ul class="tabs tabs-mg">
            <li class="tab col s3"><a class="{{ !empty($profileNav) && $profileNav == 'profile' ? 'active' : ''}}" target="_self" href="{{ route('profile') }}">Profil</a></li>
            <li class="tab col s3"><a class="{{ !empty($profileNav) && $profileNav == 'cart' ? 'active' : ''}}" target="_self" href="{{ route('cart') }}">Belanjaan</a></li>
            <li class="tab col s3"><a class="{{ !empty($profileNav) && $profileNav == 'order' ? 'active' : ''}}" target="_self" href="{{ route('orders') }}">Pesanan</a></li>
            <li class="tab col s3"><a class="{{ !empty($profileNav) && $profileNav == 'wishlist' ? 'active' : ''}}" target="_self" href="{{ route('wishlists') }}">Favorit</a></li>
        </ul>
    </div>
</div>