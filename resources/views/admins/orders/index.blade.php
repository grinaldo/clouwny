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
                <th>Status</th>
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

function initTNBar(el) {
    var container = $(el).parent().parent();
    var currentValue = container.find('.tn-container').text();
    container.html('<input type="text" value="' + currentValue + '" onkeypress="return initChangeTN(event, this)">');
}

function initChangeTN(e, el) {
    if (e.keyCode == 13) {
        var trackingNumber = $(el).val();
        var orderNumber    = $(el).parent().parent().find('td')[0].innerHTML;
        var csrf = $('meta[name=csrf-token]').attr("content");
        $.ajax({
            /* the route pointing to the post function */
            url: '/backend/orders/tracking-number/update',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: csrf, tracking_number: trackingNumber, order_number: orderNumber},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function success(data) {
                var content = '<div class="tn-container">'+data.tracking_number+'</div> <b><a href="#" class="edit-tn" onclick="initTNBar(this)">[<i class="fa fa-icon fa-edit"></i> edit]</a></b>';
                $(el).parent().html(content);
            },
            error: function error(data) {
            }
        });
    }
}
</script>
@endsection