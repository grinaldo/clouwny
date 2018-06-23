@extends('layouts.master')

@section('page-title')
Clouwny | Edit Profile
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.min.css">
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
                <div class="col s12">
                    {!! Form::model(
                            $model, 
                            [
                                'class'  => 'form-site',
                                'route'  => ['profile.update',$model],
                                'method' => 'POST'
                            ]
                        ) 
                    !!}
                        <div class="row">
                            <div class="col s6">
                                {!! Form::hidden('username') !!}
                                <h5>General Info</h5>
                                <div class="input-field col s12">
                                    {!! Form::text('name', $model->name, ['class' => 'form-site-input']) !!}
                                    <label for="name" class="active">Name</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('birthday', $model->birthday, ['class' => 'datepicker form-site-input']) !!}
                                    <label for="birthday" class="active">Date of Birth</label>
                                </div>

                                <h5>Contact</h5>
                                <div class="input-field col s12">
                                    {!! Form::email('email', $model->email, ['class' => 'form-site-input']) !!}
                                    <label for="email" class="active">Email</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('phone', $model->phone, ['class' => 'form-site-input']) !!}
                                    <label for="phone" class="active">Phone Number</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('confirmation_account', $model->confirmation_account) !!}
                                    <label for="confirmation_account" class="active">Akun Konfirmasi</label>
                                </div>
                                <h5>Password</h5>
                                <small>*input characters and numbers with minimum length of 8</small>
                                <div class="input-field col s12">
                                    {!! Form::password('password', ['class' => 'form-site-input']) !!}
                                    <label for="password" class="active">Password</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::password('password_confirmation', ['class' => 'form-site-input']) !!}
                                    <label for="password_confirmation" class="active">Verify Password</label>
                                </div>
                            </div>
                            <div class="col s6">
                                <h5>Address</h5>
                                <div class="input-field col s12">
                                    <label for="province" class="active">Provinsi</label>
                                    {!! Form::select('province', $provinces) !!}
                                </div>
                                <div class="input-field col s12">
                                    <label for="city" class="active">Kota</label>
                                    {!! Form::select('city', $cities) !!}
                                </div>
                                {{ \Auth::user()->district }}
                                <div class="input-field col s12">
                                    <label for="district" class="active">Kecamatan</label>
                                    {!! Form::select('district', $districts) !!}
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('zipcode', $model->zipcode, ['class' => 'form-site-input']) !!}
                                    <label for="zipcode" class="active">Zipcode</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::textarea('address', $model->address, ['class' => 'materialize-textarea form-site-input']) !!}
                                    <label for="address" class="active">Address Detail</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>
$('.datepicker').datepicker();
</script>
@endsection