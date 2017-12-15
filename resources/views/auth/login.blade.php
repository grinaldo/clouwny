@extends('layouts.master')

@section('page-title')
Clouwny | Login
@endsection

@section('content')
<section class="section pad-vertical-hero">
    <div class="container container--mid-container">
        <div class="row">
            <div class="col m6 s12">
                <h2>Login</h2>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control form-site-input" name="email" value="{{ old('email') }}" required autofocus>

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

                    <div class="form-group">
                        <a class="" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a> | 
                        <a href="{{ route('register') }}">
                            New Here?
                        </a>
                    </div>

                    <br><br>
                    {{-- <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn-uniform" onclick="">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col m6 s12">
                <img src="{{ asset('images/shopping.jpg') }}" style="width:100%;" alt="">
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection