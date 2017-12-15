@extends('layouts.master')

@section('page-title')
Clouwny | Wallet Transaction
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col s6">
                <h3>My Wallet</h3>
                <p>
                    <b>My Balance: </b> Rp {{ Auth::user()->wallet }} ,-
                </p>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('wallet.transaction') }}">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="input-field col s12">
                            <select class="" name="type">
                                <option value="top-up">Top Up</option>
                                <option value="withdrawal">Withdraw</option>
                            </select>
                            <label>Transaction Type</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="amount" class="active">Amount</label>   
                            <input placeholder="amount" id="amount" type="number" class="validate form-site-input" name="amount" value="{{ !empty(old('amount')) ? old('amount') : Auth::user()->amount }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="Request" class="btn-uniform" onclick="">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s6">
                <h3>Transaction</h3>
                <table class="striped">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Request Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($transactions) && count($transactions))
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">No transaction made</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection