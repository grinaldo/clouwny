@extends('admins._layouts.table')

@section('page-title')
<h3>Categories Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="social-media-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Url</th>
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
    $('#social-media-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.social-media.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'url', name: 'url' },
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