@extends('admins._layouts.default')

@section('page-title')
    @yield('page-title')
@endsection

@section('page-breadcrumb')
    @yield('page-breadcrumb')
    <li>
        <i class="fa fa-angle-right"></i>
        {{ $pageName }}
    </li>
@stop

@section('content')
    {!! Form::model(
            $model, 
            [
                'route'     => ($model->exists ? ['backend.'.$routePrefix.'.update',$model] : 'backend.'.$routePrefix.'.store'),
                'method'    => ($model->exists ? 'PUT' : 'POST'),
                'class'     => 'form-horizontal form-label-left'
            ]
        ) 
    !!}
    {!! Form::backendSelect('role', 'Role', $roles) !!}
    {!! Form::backendText('name', 'Name') !!}
    {!! Form::backendText('wallet', 'Wallet') !!}
    {!! Form::backendText('username', 'Username') !!}
    {!! Form::backendEmail('email', 'Email') !!}
    {!! Form::backendPassword('password', 'Password') !!}
    {!! Form::backendPassword('password_confirmation', 'Password Confirmation') !!}

    {!! Form::backendDate('birthday', 'Birthday') !!}
    {!! Form::backendSelect('gender', 'Gender', ['male' => 'Male', 'female' => 'Female']) !!}
    {!! Form::backendText('phone', 'Phone') !!}
    {!! Form::backendText('province', 'Province') !!}
    {!! Form::backendText('city', 'City') !!}
    {!! Form::backendText('district', 'District') !!}
    {!! Form::backendText('zipcode', 'Zipcode') !!}
    {!! Form::backendTextarea('address', 'Address Details') !!}

    {!! Form::backendNumber('order', 'Order') !!}
    {!! Form::backendFileBrowser('image', "Select Image")!!}
    {!! Form::backendSelect('published', 'Published', ['No', 'Yes']) !!}
    
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                {!! Form::backendSubmit() !!}
                {!! Form::backendReset() !!}
                {!! Form::backendBack() !!}
            </div>
        </div>
    </div>

{!! Form::close() !!}
@endsection

@section('page-script')
@endsection