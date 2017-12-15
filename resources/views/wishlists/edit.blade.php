@extends('layouts.master')

@section('page-title')
Clouwny | My Wishlist
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
                                    {!! Form::date('birthday', $model->birthday, ['class' => 'datepicker form-site-input']) !!}
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
                                    {!! Form::text('Province', $model->province, ['class' => 'form-site-input']) !!}
                                    <label for="province" class="active">Province</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('city', $model->city, ['class' => 'form-site-input']) !!}
                                    <label for="city" class="active">City</label>
                                </div>
                                <div class="input-field col s12">
                                    {!! Form::text('district', $model->district, ['class' => 'form-site-input']) !!}
                                    <label for="district" class="active">District</label>
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
<script>    
$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 60, // Creates a dropdown of 15 years to control year,
    max: new Date(),
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false // Close upon selecting a date,
});
</script>
@endsection