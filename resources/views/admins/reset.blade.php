@extends('admins._layouts.login')

@section('page-title')
<h3>Reset Password</h3>
@endsection

@section('content')
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <form role="form" method="POST" action="{{ route('password.request') }}">
                <div class="">
                    <img src="{{asset('images/logo.png')}}" width="100" alt="">
                </div>
                <br>
                <h1>Password Reset</h1>
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'email' , 'required']) !!}
                </div>

                <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'password' , 'required']) !!}
                </div>

                <div class="{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'password' , 'required']) !!}
                </div>

                <div>
                    <button type="submit" class="btn btn-default submit" href="index.html"> Reset
                    </button>
                    {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div>
                        <h1><i class="fa fa-user"></i> Izasi Admin</h1>
                        <p>©2018 All Rights Reserved. CMS for Izasi Website</p>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('page-script')
@endsection