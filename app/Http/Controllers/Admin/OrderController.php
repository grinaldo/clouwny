<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order as Model;
use App\Model\OrderStatus;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;

class OrderController extends ResourceController
{

    /**
     * Form Rules
     * @var array
     */
    protected $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'order_number' => 'alpha_dash|unique:orders,order_number',
        'latest_status' => 'sometimes|nullable|string',
        'is_dropship' => 'boolean',
        'shipper_name' => 'sometimes|nullable|string',
        'shipper_phone' => 'sometimes|nullable|string',
        'shipper_email' => 'sometimes|nullable|string',
        'shipper_city' => 'sometimes|nullable|string',
        'shipper_district' => 'sometimes|nullable|string',
        'shipper_zipcode' => 'sometimes|nullable|string',
        'shipper_address' => 'sometimes|nullable|string',
        'receiver_name' => 'string',
        'receiver_phone' => 'string',
        'receiver_email' => 'sometimes|nullable|string',
        'receiver_city' => 'string',
        'receiver_district' => 'string',
        'receiver_zipcode' => 'string',
        'receiver_address' => 'string'
    ];

    /**
     * Column Edit
     * ['column_name', 'edit value']
     *
     * @var array
     */
    protected $columnEdit = [
        [
            'latest_status',
            '{!! $latest_status=="Order Shipped"?"<span class=\"label label-success\">$latest_status</span>":"<span class=\"label label-warning\">$latest_status</span>" !!}'
        ]
    ];

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    protected function beforeValidate()
    {
        parent::beforeValidate();
        // Put your form requirement here
        // e.g. $this->form->setModelId($this->model->getKey());
    }

    protected function formRules()
    {
        if ($this->model->exists) {
            foreach(['slug','name'] as $key) {
                $this->rules[$key] .= ','.$this->model->getKey();
            }
        } else {
            $this->rules['slug'] = 'sometimes|nullable|'.$this->rules['slug'];
        }
        parent::formRules();
    }

    public function formData()
    {
        parent::formData();
        view()->share([
            'orderStatuses' => Model::orderStatuses()
        ]);
    }

    protected function doSave() 
    {
        parent::doSave();
    }

    public function create()
    {
        session()->flash(NOTIF_WARNING, 'Should not create order manually!');
        return redirect()->back();
    }
    
    public function updateStatus(Request $request)
    {
        $orderStatus = new OrderStatus($request->all());
        $orderStatus->save();

        $order = Model::find($request->order_id);
        $order->latest_status   = $request->status;
        $order->tracking_number = $request->tracking_number;
        $order->save();
        session()->flash(NOTIF_SUCCESS, 'Order status updated!');
        return redirect()->route('backend.orders.index');
    }

    public function printLabel($id)
    {
        $model = Model::find($id);
        return view('admins.orders.label', ['model' => $model]);
    }
}
