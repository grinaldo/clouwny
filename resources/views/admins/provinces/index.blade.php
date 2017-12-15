@extends('admins._layouts.table')

@section('page-title')
<h3>Provinces Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="provinces-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@stop

@section('page-script')
<script>
$(function() {
    $('#provinces-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.provinces.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection