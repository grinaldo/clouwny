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
                    <h3>Thank You for Shopping</h3>
                </center>
                <div class="divider"></div>
            </div>
        </div>
        <div class="row">
            <div class="col m6 s12">
                <center class="text-center">
                    <img width="300" src="{{ asset('images/box.png') }}" alt="">
                    <div>
                        <span class="white-text pad-1x bg-pink-lighten">
                            <b>Payment:</b> Rp. {{ number_format($totalFee) }},-
                        </span>
                    </div>
                    <br>
                    <p class="grey-text">
                        <b>Your order will be processed between 1x24 hours after the package has been shipped. (Working hour: Mon-Fri: 10-5pm / Sat 10-2pm)</b>
                        <br>
                        You may check your order status on your <strong>order details</strong> or via <strong>tracking number</strong> updated on your order.
                        <br>
                        <b>NO DELIVERY on Sunday and public holidays</b>
                    </p>
                </center>
            </div>
            <div class="col m6 s12">
                <h4>Confirmation</h4>
                <p>You may inform your account for us to confirm with you</p>
                <br>
                {!! Form::open(['route' => 'orders.thanks.confirm']) !!}
                <div class="row">
                    {!! Form::hidden('id', $id) !!}
                    <div class="input-field col m6 s12">
                        <label for="confirmation_channel" class="active">Confirmation Channel</label>   
                        {!! Form::select('confirmation_channel', ['Line' => 'Line', 'Whatsapp' => 'Whatsapp', 'Others' => 'Others']) !!}
                    </div>
                    <div class="input-field col m6 s12">
                        
                        <label for="confirmation_account" class="active">Confirmation Account</label>       
                        <input placeholder="Your Account, e.g: @clouwny" id="confirmation_account" type="text" class="validate form-site-input" name="confirmation_account" value="{{ !empty(old('confirmation_account')) ? old('confirmation_account') : "" }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col m6 s12">
                        <div class="input-field">
                            {!! Form::select('confirmation_transfer', $banks) !!}
                            <label for="Transfer Via">Payment Method</label>
                        </div>
                    </div>
                    <div class="input-field col m6 s12">
                        <label for="confirmation_payer" class="active">Payment Account Name</label>       
                        <input placeholder="Leave it blank for wallet" id="confirmation_payer" type="text" class="validate form-site-input" name="confirmation_payer" value="{{ !empty(old('confirmation_payer')) ? old('confirmation_payer') : "" }}">
                    </div>
                </div>
                <div>
                    <button class="btn-uniform" type="submit"><b>Confirm</b></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection