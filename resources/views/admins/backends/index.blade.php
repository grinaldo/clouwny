@extends('admins._layouts.default')

@section('page-title')
<h3>Backend Dashboard</h3>
@endsection

@section('content')
<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="tile-stats">
        <div class="icon"><i class="fa fa-user"></i></div>
            <div class="count">{{ $users }}</div>
            <h3>Total User</h3>
            <p>Registered users on site</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-comments-o"></i></div>
            <div class="count"> {{ $contacts }} </div>
            <h3>Contacts Forms</h3>
            <p>Contacts by guest on site</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-file"></i></div>
            <div class="count"> {{ $orders }} </div>
            <h3>Orders</h3>
            <p>Orders coming on site</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
        <div class="icon"><i class="fa fa-check-square-o"></i></div>
        <div class="count"> {{$wallets}} </div>
        <h3>Wallet Transaction</h3>
        <p>Wallet transaction requested</p>
        </div>
    </div>
</div>

<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-file"></i> Open Order</span>
        <div class="count red"> {{ $orders - $ov }} </div>
        <span class="count_bottom">Need to be fulfilled</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-money"></i> Wallet Requests</span>
        <div class="count red"> {{ $wv }} </div>
        <span class="count_bottom">Need to be processed</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-shopping-bag"></i> Zero Stocks</span>
        <div class="count red"> {{ $zeroStock }} </div>
        <span class="count_bottom">Need to be restocked</span>
    </div>
</div>
@stop

@section('page-script')
@endsection