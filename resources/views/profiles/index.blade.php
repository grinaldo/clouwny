@extends('layouts.master')

@section('page-title')
Clouwny | My Profile
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m12 s12">
                <center><h2>My Account</h2></center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                @include('_includes._profile-navigation')
                <div id="profile" class="col s12">
                    <div class="row">
                        <div class="col m12 s12">
                            <div class="row">
                                <div class="col m6 s6">
                                    <h4 class="grey-text">Profile - Edit</h4>
                                </div>
                                <div class="col m6 s6" style="text-align:right">
                                    <a href="{{ route('profile.edit') }}" class="btn-uniform button-box--align-1x">Edit Profile</a>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <br>
    
                            <h5>My Wallet</h5>
                            <dl class="profile-table">
                                <dt>Balance: 
                                </dt>    
                                <dd>
                                    IDR {{ Auth::user()->wallet }},-
                                    <a href="{{ route('wallet') }}" class="btn-uniform button-box--align-1x pull-right">Transaction</a>
                                </dd>
                            </dl>

                            <h5>General Info</h5>
                            <dl class="profile-table">
                                <dt>Username: </dt>
                                <dd>{{ Auth::user()->username }}</dd>
                            </dl>
                            <dl class="profile-table">
                                <dt>Name: </dt>
                                <dd>{{ Auth::user()->name }}</dd>
                            </dl>
                            <dl class="profile-table">
                                <dt>Date of Birth: </dt>
                                <dd>{{ Auth::user()->birthday }}</dd>
                            </dl>
                            <dl class="profile-table">
                                <dt>Gender: </dt>
                                <dd>{{ Auth::user()->gender }}</dd>
                            </dl>

                            <h5>Contact</h5>
                            <dl class="profile-table">
                                <dt>Email: </dt>
                                <dd>{{ Auth::user()->email }}</dd>
                            </dl>
                            <dl class="profile-table">
                                <dt>Phone: </dt>
                                <dd>{{ Auth::user()->phone }}</dd>
                            </dl>

                            <h5>Password</h5>
                            <dl class="profile-table">
                                <dt>Password: </dt>
                            </dl>
                        </div>
                    </div>
                    
                </div>
                {{-- <div id="cart" class="col s12">
                    <h4 class="grey-text">My Shopping Bag</h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>Long dress with cute frilly skirt</td>
                                <td>1</td>
                                <td>Rp. 150.000,-</td>
                                <td><button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-close" title="remove"></i></button></td>
                            </tr>
                            <tr>
                                <td><img src="{{ asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>Long dress with cute frilly skirt</td>
                                <td>2</td>
                                <td>Rp. 200.000,-</td>
                                <td><button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-close" title="remove"></i></button></td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th>3</th>
                                    <th>Rp 350.000,-</th>
                                    <th><button class="button-box button-foo" type="submit">Checkout</button></th>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
                <div id="order" class="col s12">
                    <h4 class="grey-text">My Order</h4>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>123-456-789</td>
                                <td>Unverified</td>
                                <td>2017-07-17 10:11:29</td>
                                <td>
                                    <button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-search" title="detail"></i></button>
                                    <button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-check" title="Verify"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>123-456-789</td>
                                <td>Finished</td>
                                <td>2017-07-17 10:11:29</td>
                                <td><button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-search" title="detail"></i></button></td>
                            </tr>
                            <tr>
                                <td>123-456-789</td>
                                <td>On Delivery</td>
                                <td>2017-07-20 13:00:45</td>
                                <td><button class="button-box button-foo" type="submit"><i class="fa fa-icon fa-search" title="detail"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="wishlist" class="col s12">
                    <h4 class="grey-text">My Wishlist</h4>
                     <table class="striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset('images/dummy-1.jpg') }}" width="100" alt=""></td>
                                <td>Long dress with frilly skirt</td>
                                <td><a href="">
                                    <button class="button-box button-foo" type="submit"><b>Add to Cart</b></button></a>
                                    <button class="button-box button-foo" type="submit"><b><i class="fa fa-icon fa-close" title="remove"></i></b></button></a>
                                </td>
                            </tr>
                            <tr>
                                <td><img src="{{ asset('images/dummy-2.jpg') }}" width="100" alt=""></td>
                                <td>Long dress with frilly skirt</td>
                                <td><a href="">
                                    <button class="button-box button-foo" type="submit"><b>Add to Cart</b></button></a>
                                    <button class="button-box button-foo" type="submit"><b><i class="fa fa-icon fa-close" title="remove"></i></b></button></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection