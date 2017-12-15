@extends('layouts.master')

@section('page-title')
Clouwny | Order Detail
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
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="#delivery">Delivery Info</a></li>
                    <li class="tab col s4"><a href="#status">Statuses</a></li>
                    <li class="tab col s4"><a href="#items">Items</a></li>
                    <li class="tab col s4"><a href="#items">Confirmation</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col s12" id="delivery">
                <h4>Delivery Info</h4>
                <p class="grey-text">
                    <b>Latest Status: </b> {{ $order->latest_status }}
                    <br>
                    <b>Order Date: </b> {{ $order->created_at }}
                    <br>
                    <b>Shipment: </b> {{ $order->is_dropship ? 'Dropship' : 'normal' }}
                    <br>
                    <b>Delivery Service: </b> {{ $order->delivery_type }}
                    <br>
                    <b>Payment Info: </b> {{ $order->payment_method }}
                </p>
                <table class="striped">
                    <thead>
                        <tr>
                            <th width="50%">Receiver Info</th>
                            <th width="50%">Dropship Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Name:</b> {{ $order->receiver_name }}</td>
                            <td><b>Name:</b> {{ $order->is_dropship ? $order->shipper_name : '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone:</b> {{ $order->receiver_phone }}</td>
                            <td><b>Phone:</b> {{ $order->is_dropship ? $order->shipper_phone : '-' }}</td>
                        </tr>
                        <tr>
                            <td><b>Province:</b> {{ $order->receiver_province }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>City:</b> {{ $order->receiver_city }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>District:</b> {{ $order->receiver_district }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Zipcode:</b> {{ $order->receiver_zipcode }}</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td><b>Address:</b> {{ $order->receiver_address }}</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col s12" id="status">
                <div class="row">
                    <div class="col m6 s12">
                        <h4>Statuses</h4>
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Time</th>
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
                        <h4>Payment Confirmation</h4>
                        <p>Your contact for payment confirmation</p>
                        {!! Form::open(['route' => 'orders.confirm']) !!}
                            {!! Form::hidden('id', $order->id) !!}
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        {!! Form::select('confirmation_transfer', $banks) !!}
                                        <label for="Transfer Via">Payment Method</label>
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_payer" class="active">Payment Account Name</label>   
                                        <input placeholder="Your Account Name for Payment (if transfer)" id="confirmation_payer" type="text" class="validate form-site-input" name="confirmation_payer" value="{{ $order->confirmation_payer }}">
                                    <div class="input-field">
                                        <label for="confirmation_date" class="active">Confirmation Date</label>   
                                        <input placeholder="Your Account e.g: @my_line" id="confirmation_date" type="date" class="validate form-site-input" name="confirmation_date" value="{{ $order->confirmation_date }}">
                                    </div>
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_channel" class="active">Confirmation Channel</label>   
                                        {!! Form::select('confirmation_channel', ['Line' => 'Line', 'Whatsapp' => 'Whatsapp', 'Others' => 'Others'], $order->confirmation_account) !!}
                                    </div>
                                    <div class="input-field">
                                        <label for="confirmation_account" class="active">Confirmation Account</label>   
                                        <input placeholder="Your Account e.g: @my_line" id="confirmation_account" type="text" class="validate form-site-input" name="confirmation_account" value="{{ $order->confirmation_account }}">
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
                            <td>{{ $orderItem->product()->first()->name }}</td>
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
@endsection