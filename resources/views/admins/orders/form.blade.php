@extends('admins._layouts.default')

@section('page-title')
    @yield('page-title')
@endsection

@section('page-breadcrumb')
    @yield('page-breadcrumb')
    <li>
        <i class="fa fa-angle-right"></i>
        {{ $pageName }}
    </li>
@stop

@section('content')
    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_content1" id="order-tab" role="tab" data-toggle="tab" aria-expanded="true">Details</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content2" role="tab" id="receiver-tab" data-toggle="tab" aria-expanded="false">Receiver</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content3" role="tab" id="shipper-tab" data-toggle="tab" aria-expanded="false">Shipper</a>
            </li>
            <li role="presentation" class=""><a href="#tab_content4" role="tab" id="status-tab" data-toggle="tab" aria-expanded="false">Status</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="order-tab">
                <div class="x_panel">
                    <h3>Order Details</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <b>Dropship Status: </b>
                                {!! strlen($model->is_dropship) ? '<span class="label label-info">Normal Shipment</span>':'<span class="label label-warning">Dropship</span>' !!}
                            </p>
                            <p>
                                <b>Payment: </b> 
                                @if($model->payment_method == 'transfer')
                                <span class="label label-info">Transfer</span>
                                @else
                                <span class="label label-success">Wallet</span>
                                @endif
                            </p>
                            <p>
                                <b>Delivery: </b> 
                                <span class="label label-danger">{{ $model->delivery_type }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ url('backend/orders/'.$model->id.'/print-label') }}" class="btn btn-primary">
                                <i class="fa fa-print"></i> Print Label
                            </a>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Buyer</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $model->user()->first()->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $model->user()->first()->email }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $model->user()->first()->phone }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Amount</th>
                                <th>Sold Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($model->orderItems()->get() as $item)
                                <tr>
                                    <td>{{ $item->product()->first()->name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->sold_price }}</td>
                                    <td>{{ $item->amount * $item->sold_price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="receiver-tab">
                <div class="x_panel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Receiver's Data</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $model->receiver_name }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $model->receiver_phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $model->receiver_email }}</td>
                            </tr>
                            <tr>
                                <td>Province</td>
                                <td>{{ $model->receiver_province }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{ $model->receiver_city }}</td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td>{{ $model->receiver_district }}</td>
                            </tr>
                            <tr>
                                <td>Zipcode</td>
                                <td>{{ $model->receiver_zipcode }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $model->receiver_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="shipper-tab">
                <div class="x_panel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Shipper's Data</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $model->shipper_name }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>{{ $model->shipper_phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $model->shipper_email }}</td>
                            </tr>
                            <tr>
                                <td>Province</td>
                                <td>{{ $model->shipper_province }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{ $model->shipper_city }}</td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td>{{ $model->shipper_district }}</td>
                            </tr>
                            <tr>
                                <td>Zipcode</td>
                                <td>{{ $model->shipper_zipcode }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $model->shipper_address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="status-tab">
                <div class="x_panel">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($model->statuses()->get()))
                            @foreach($model->statuses()->get() as $status)
                            <tr>
                                <td>{{ $status->status }}</td>
                                <td>{{ $status->created_at }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No Statuses</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="ln_solid"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>Update Order Status</h3>
                            <br><br>
                            {!! Form::model(
                                    $model, 
                                    [
                                        'route'     => 'backend.orders.status.update',
                                        'method'    => 'POST',
                                        'class'     => 'form-horizontal form-label-left'
                                    ]
                                ) 
                            !!}
                                {!! Form::backendSelect('status', 'Status', $orderStatuses) !!}
                                {!! Form::backendText('tracking_number', 'Tracking Number') !!}
                                {!! Form::hidden('order_id', $model->id) !!}
                                <br><br>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            {!! Form::backendSubmit() !!}
                                            {!! Form::backendBack() !!}
                                        </div>
                                    </div>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ln_solid"></div>
@endsection

@section('page-script')
@endsection