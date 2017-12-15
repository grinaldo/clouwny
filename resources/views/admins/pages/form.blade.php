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
    {!! Form::backendText('slug', 'Slug') !!}
    {{-- {!! Form::backendText('url_prefix', 'URL') !!} --}}
    {{-- {!! Form::backendText('layout', 'Layout') !!} --}}
    {!! Form::backendText('name', 'Name') !!}
    {!! Form::backendWysiwyg('title', 'Title') !!}
    {!! Form::backendText('short_title', 'Short Title') !!}
    {!! Form::backendTextarea('short_description', 'Short Description') !!}
    {!! Form::backendWysiwyg('description', 'Description') !!}

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