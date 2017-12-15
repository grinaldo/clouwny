@extends('admins._layouts.table')

@section('page-title')
<h3>Pages Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="pages-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Title</th>
                <th>Published At</th>
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
    $('#pages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.pages.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'title', name: 'title' },
            { data: 'published_at', name: 'published_at' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection