@extends('admins._layouts.table')

@section('page-title')
<h3>Wallet Transaction Data</h3>
@endsection

@section('content')
    <table class="table table-bordered" id="wallets-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@stop

@section('page-script')
<script>
$(function() {
    $('#wallets-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('backend.wallets.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user.name', name: 'user.name' },
            { data: 'type', name: 'type' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
});
</script>
@endsection