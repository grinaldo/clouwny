@extends('admins._layouts.table')

@section('page-title')
<h3>Bank Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="contacts-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Bank Name</th>
                <th>Account Name</th>
                <th>Account Number</th>
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
    $('#contacts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.banks.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'bank_name', name: 'bank_name' },
            { data: 'account_name', name: 'account_name' },
            { data: 'account_number', name: 'account_number' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection