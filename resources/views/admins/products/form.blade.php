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

<template id="variant-template">
    <div class="x_panel">
        <div class="x_title">
            <h2>Product Variant - {#}</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: block;" data-num="{#}">
            {!! Form::hidden("product_variants[{#}][id]")!!}
            {!! Form::backendText('product_variants[{#}][name]', 'Name') !!}
            {!! Form::backendNumber('product_variants[{#}][stock]', 'Stock') !!}
            {!! Form::backendTextarea('product_variants[{#}][description]', 'Short Description') !!}
        </div>
    </div>
</template>

<template id="image-template">
    <div class="x_panel">
        <div class="x_title">
            <h2>Product Image - {#}</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content" style="display: block;" data-num="{#}">
            {!! Form::hidden("product_images[{#}][id]")!!}
            {!! Form::backendFileBrowser('product_images[{#}][image]', 'Image') !!}
        </div>
    </div>
</template>


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
    {!! Form::backendSelect('category_id', 'Category', $categories) !!}
    {!! Form::backendText('name', 'Name') !!}
    {!! Form::backendNumber('order', 'Order') !!}
    {!! Form::backendNumber('weight', 'Weight (gram)') !!}
    {!! Form::backendNumber('stock', 'Total Stock') !!}
    {!! Form::backendTextarea('short_description', 'Short Description') !!}
    {!! Form::backendWysiwyg('description', 'Description') !!}
    {!! Form::backendNumber('discounted_price', 'Discounted Price') !!}
    {!! Form::backendNumber('price', 'Price') !!}
    {!! Form::backendNumber('actual_price', 'Actual Price') !!}
    {!! Form::backendSelect('is_sale', 'Sale', [false => 'No', true => 'Yes']) !!}
    {!! Form::backendSelect('is_featured', 'Featured', [false => 'No', true => 'Yes']) !!}
    {!! Form::backendFileBrowser('image', "Select Image")!!}
    {!! Form::backendSelect('published', 'Published', ['No', 'Yes']) !!}
    
    {{-- ========= Product Variants ========= --}}

    <div class="x_title">
        <h2>Product Variants<small>your product variant list</small></h2>
        <div class="clearfix"></div>
    </div>

    <div id="variant-container">
        @if(!empty($model->getKey()))
        @foreach($model->variants()->get() as $key => $variant)
        <div class="x_panel">
        <div class="x_title">
            <h2>Product Variant - {{$key+1}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;" data-num="{{$key}}">
                {!! Form::hidden('product_variants['.$key.'][id]', $variant->getKey())!!}
                {!! Form::backendText('product_variants['.$key.'][name]', 'Name', $variant->name) !!}
                {!! Form::backendNumber('product_variants['.$key.'][stock]', 'Stock', $variant->stock) !!}
                {!! Form::backendTextarea('product_variants['.$key.'][description]', 'Short Description', $variant->description) !!}
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <button class="btn btn-primary" id="variant-button">
        Add Variant
    </button>
    <br>
    <div class="ln_solid"></div>
    <br>

    {{-- ========= Product Images ========= --}}

    <div class="x_title">
        <h2>Product Images<small>your product image list</small></h2>
        <div class="clearfix"></div>
    </div>

    <div id="image-container">
        @if(!empty($model->getKey()))
        @foreach($model->images()->get() as $key => $image)
        <div class="x_panel">
        <div class="x_title">
            <h2>Product Images - {{$key+1}}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;" data-num="{{$key}}">
                {!! Form::hidden('product_images['.$key.'][id]', $image->getKey())!!}
                {!! Form::backendFileBrowser('product_images['.$key.'][image]', 'Image', $image->image) !!}
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <button class="btn btn-primary" id="image-button">
        Add Image
    </button>
    <br>
    <div class="ln_solid"></div>
    <br>


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
<script>
    FormField.initTemplate('#image-template', '#image-container', '#image-button');
    FormField.initTemplate('#variant-template', '#variant-container', '#variant-button');
</script>
@endsection