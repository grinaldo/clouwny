<ul id="slide-out" class="side-nav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="{{ asset('images/bg-menu.jpg') }}">
            </div>
            <br>
            <br>
        </div>
    </li>
    <li><a class="subheader">Our Shop</a></li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Collection<i class="material-icons">arrow_drop_down</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{ url('products') }}">All Collections</a></li>
                        @if(!empty($allCategories) && count($allCategories))
                        @foreach($allCategories as $category)
                        <li><a href="{{ url('products/'.$category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li><div class="divider"></div></li>
    @if(Auth::check())
    <li><a class="subheader">Welcome, {{ Auth::user()->username }}</a></li>
    @else
    <li><a href="{{ url('login') }}" class="waves-effect"><i class="fa fa-icon fa-sign-in"></i>Login</a></li>
    <li><a href="{{ url('register') }}" class="waves-effect"><i class="fa fa-icon fa-pencil"></i>Register</a></li>
    @endif
    <li><a href="{{ route('home') }}" class="waves-effect"><i class="fa fa-icon fa-home"></i>Home</a></li>
    @if(!Auth::guest())
    <li><a href ="{{ route('cart') }}" class="waves-effect"><i class="fa fa-icon fa-shopping-bag"></i>My Bag</a></li>
    <li><a href="{{ route('profile') }}" class="waves-effect"><i class="fa fa-icon fa-user"></i>Profile</a></li>
    @endif
    <li><a href ="{{ route('wishlists') }}" class="waves-effect"><i class="fa fa-icon fa-heart"></i>Wishlist</a></li>
    <li><a href ="{{ route('orders') }}" class="waves-effect"><i class="fa fa-icon fa-sticky-note"></i>Order</a>
    </li>
    @if(Auth::check())
    <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
        <form  id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
                </form>
    </li>
    @endif
    <li><div class="divider"></div></li>
    <li><a href ="{{ route('faqs') }}" class="waves-effect">FAQs</a></li>
    <li><a href ="{{ route('contacts') }}" class="waves-effect">Contacts</a></li>
    <li><a href ="{{ route('about') }}" class="waves-effect">About</a></li>
    <li><div class="divider"></div></li>
</ul>