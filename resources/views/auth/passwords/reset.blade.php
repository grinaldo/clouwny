@extends('layouts.master')

@section('page-title')
Clouwny | Reset Password
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
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control form-site-input" name="email" value="{{ $email or old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong class="warning-text">{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control form-site-input" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong class="warning-text">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control form-site-input" name="password_confirmation" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong class="warning-text">{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn-uniform">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
                
@endsection
