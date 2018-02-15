<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order as Model;
use App\Model\OrderStatus;
use App\Model\User;
use App\Model\Product;
use App\Model\ProductVariant;

use Mail;
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
        'tracking_number' => 'sometimes|nullable|string|unique:orders,tracking_number',
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
        ],
        [
            'tracking_number', 
            '<div class="tn-container">{{$tracking_number}}</div> <b><a href="#" class="edit-tn" onclick="initTNBar(this)">[<i class="fa fa-icon fa-edit"></i> edit]</a></b>'
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

        $order = Model::find($request->order_id);
        $order->latest_status   = $request->status;
        $order->tracking_number = $request->tracking_number;

        $shippedOrderCount = OrderStatus::where('order_id', '=', $order->id)
            ->where('status', '=', Model::ORDER_STATUS_SHIPPED)
            ->count();
        /**
         * Format for fulfillment
         * [
         *     'product_id' => [
         *         'variant_id_1' => 'amount',
         *         'variant_id_2' => 'amount'
         *     ]
         * ]
         * 
         * @var array
         */
        $productToDeplete = [];
        if ($request->status == Model::ORDER_STATUS_SHIPPED &&
            $shippedOrderCount == 0
        ) {
            foreach ($order->orderItems()->get() as $variant) {
                if (!empty($productToDeplete[$variant->product_id]) && 
                    count($productToDeplete[$variant->product_id]) 
                ) {
                    $productToDeplete[$variant->product_id][$variant->product_variant_id] += $variant->amount;
                } else {
                    $productToDeplete[$variant->product_id][$variant->product_variant_id] = $variant->amount;
                }
            }

            foreach ($productToDeplete as $key => $ptd) {
                $productGet = Product::find($key);
                foreach ($ptd as $pkey => $pv) {
                    $variantGet = ProductVariant::find($pkey);
                    if (!empty($variantGet)) {
                        $variantGet->stock -= $pv;
                        $variantGet->save();
                        $productGet->stock -= $pv;
                    }
                }
                $productGet->save();
            }

            // Send Email
            \Mail::send(
                'emails.ordership',
                [
                    'title' => 'Order Shipped!',
                    'order' => $order
                ], 
                function ($message) use ($order) {
                    $message->from('ov@clouwny.com', 'Clouwny');
                    $message->to($order->receiver_email);
                    $message->subject("Clouwny Order Shipped");

                }
            );
        }

        $order->save();
        $orderStatus->save();

        session()->flash(NOTIF_SUCCESS, 'Order status updated!');
        return redirect()->route('backend.orders.index');
    }

    public function updateTrackingNumber(Request $request)
    {
        if ($request->ajax()) {
            $response = [
                'status'  => 'failed',
                'message' => 'Invalid Request'
            ];
            if (\Auth::check() && \Auth::user()->role !== User::ROLE_USER) {
                $order = Model::where('order_number', '=', $request->order_number)->first();
                if (!empty($order)) {
                    $order->tracking_number = $request->tracking_number;
                    $order->save();
                    $response = [
                        'status'  => 'success',
                        'type'    => 'success',
                        'message' => 'Product has been added',
                        'tracking_number' => $request->tracking_number,
                    ];
                }
            } 
            return response()->json($response); 
        }
    }

    public function printLabel($id)
    {
        $model = Model::find($id);
        return view('admins.orders.label', ['model' => $model]);
    }

    public function printOrdersIndex()
    {
        $orders = Model::where('latest_status', '<>', Model::ORDER_STATUS_SHIPPED)
            ->orWhere('latest_status', '<>', Model::ORDER_STATUS_CANCELLED)
            ->orWhere('latest_status', '<>', Model::ORDER_STATUS_REFUNDED)
            ->orWhere('latest_status', '=', null)
            ->get();
        return view('admins.orders.print', [
            'data' => $orders
        ]);
    }
}
