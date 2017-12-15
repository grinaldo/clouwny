@extends('admins.'.$viewPrefix.'.form')

@section('page-title')
<h3>New {{ $pageName }}</h3>
@endsection

@section('page-breadcrumb')
    <li>
        <i class="fa fa-angle-right"></i>
        New {{ $pageName }}
    </li>
@stop