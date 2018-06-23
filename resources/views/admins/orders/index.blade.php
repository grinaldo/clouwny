@extends('admins._layouts.table')

@section('page-title')
<h3>Orders Data</h3>
@endsection

@section('page-menu')
<a href="{{ route('backend.'.$routePrefix.'.print-orders') }}" class="btn btn-xs btn-primary"><i class="fa fa-icon fa-print"></i> Print Orders</a>
@endsection

@section('content')
    <table class="table table-bordered" id="orders-table">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Tracking Number</th>
                <th>Verify Order</th>
                <th>Ship Order</th>
                <th>Latest Status</th>
                <th>Receiver Name</th>
                <th>Receiver Phone</th>
                <th>Receiver Address</th>
                <th>Created At</th>
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
            { data: 'order_number', name: 'order_number' },
            { data: 'tracking_number', name: 'tracking_number' },
            { data: 'verify_order', name: 'verify_order' },
            { data: 'ship_order', name: 'ship_order' },
            { data: 'latest_status', name: 'latest_status' },
            { data: 'receiver_name', name: 'receiver_name' },
            { data: 'receiver_phone', name: 'receiver_phone' },
            { data: 'receiver_address', name: 'receiver_address' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']]
    });
});
</script>
<script src="{{ asset('assets/admin/js/order.js') }}"></script>
@endsection