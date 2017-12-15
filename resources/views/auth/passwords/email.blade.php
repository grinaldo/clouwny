@extends('layouts.master')

@section('page-title')
Clouwny | Login
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        @if (session('status'))
        <div class="row close-target">
            <div class="col s12">
                <div class="card-panel teal lighten-2 white-text">
                    <span>test</span>{{ session('status') }}
                    <span class="pull-right close-dialog" data-target=".close-target"><b>X</b></span>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col s6">
                <h2>Reset Password</h2>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <p>We'll send you an email for password reset</p>
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control form-site-input" placeholder="your email" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block warning-text">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <br><br>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn-uniform">
                                Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
@endsection