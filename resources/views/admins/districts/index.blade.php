@extends('admins._layouts.table')

@section('page-title')
<h3>Districts Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="districts-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Code</th>
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
    $('#districts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.districts.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection