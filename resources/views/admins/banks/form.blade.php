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
    {!! Form::backendText('bank_name', 'Bank') !!}
    {!! Form::backendText('account_name', 'Account Name') !!}
    {!! Form::backendText('account_number', 'Account Number') !!}
    {!! Form::backendTextarea('description', 'Description') !!}
    
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