@extends('admins._layouts.table')

@section('page-title')
<h3>Orders Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="orders-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Status</th>
                <th>Receiver Name</th>
                <th>Receiver Email</th>
                <th>Receiver Phone</th>
                <th>Receiver Address</th>
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
    $('#orders-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.orders.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'latest_status', name: 'latest_status' },
            { data: 'receiver_name', name: 'receiver_name' },
            { data: 'receiver_email', name: 'receiver_email' },
            { data: 'receiver_phone', name: 'receiver_phone' },
            { data: 'receiver_address', name: 'receiver_address' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']]
    });
});
</script>
@endsection