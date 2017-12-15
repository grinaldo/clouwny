<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li>
                <a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.dashboard') }}">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.users.index') }}">User Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-shopping-bag"></i> Products <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.categories.index') }}">Categories Data</a></li>
                    <li><a href="{{ route('backend.products.index') }}">Product Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-file-text"></i> Orders <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.orders.index') }}">Order Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-money"></i> Transaction <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.wallets.index') }}">Transaction Data</a></li>
                    <li><a href="{{ route('backend.banks.index') }}">Bank Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-question-circle"></i> FAQs <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.faqs.index') }}">FAQ Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-phone"></i> Contacts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.contacts.index') }}">Contact Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-file-o"></i> Pages <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.banners.index') }}">Banners</a></li>
                    <li><a href="{{ route('backend.pages.index') }}">Static Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-facebook"></i> Social Medias <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.social-media.index') }}">Social Media Data</a></li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-map-marker"></i> Location Tree <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('backend.locations.sync') }}">Sync Location Tree</a></li>
                    <li><a href="{{ route('backend.provinces.index') }}">Province</a></li>
                    <li><a href="{{ route('backend.cities.index') }}">Cities</a></li>
                    <li><a href="{{ route('backend.districts.index') }}">District</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->
