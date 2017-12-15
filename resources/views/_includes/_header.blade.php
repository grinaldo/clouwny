<header>
    <nav class="no-bg no-sd block--on-top header--sticky">
        <div class="nav-wrapper no-bg no-sd">
            <a href="/" class="brand-logo center">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </a>
            <ul id="nav-mobile pad-1x" class="left">
                <li>
                    <div class="hamburger">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </div>
                </li>
            </ul>
            <ul id="nav-mobile pad-1x" class="right user-actions">
                <li>
                    <a href="{{ route('cart') }}" class="color--black">
                        <i class="fa fa-icon fa-shopping-bag"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>