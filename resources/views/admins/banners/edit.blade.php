@extends('admins.'.$viewPrefix.'.form')

@section('page-title')
<h3>Edit {{ $pageName }}</h3>
@endsection

@section('page-breadcrumb')
    @parent
    <li>
        <i class="fa fa-angle-right"></i>
        Edit {{ $pageName }}
    </li>
@stop