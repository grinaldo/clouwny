@extends('admins._layouts.login')

@section('page-title')
<h3>Datatable Title</h3>
@endsection

@section('content')
<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">
            <form role="form" method="POST" action="{{ route('backend.login') }}">
                <h1>Login Form</h1>
                {{ csrf_field() }}
                <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'email' , 'required']) !!}
                </div>
                <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::password('password',  ['class' => 'form-control', 'placeholder' => 'password' , 'required']) !!}
                </div>
                <div>
                    <button type="submit" class="btn btn-default submit" href="index.html"> Log in
                    </button>
                    {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div>
                        <h1><i class="fa fa-female"></i> Clouwny Admin</h1>
                        <p>©2017 All Rights Reserved. CMS for Clouwny Website</p>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('page-script')
@endsection