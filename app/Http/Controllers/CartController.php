<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Bank;
use App\Model\Cart;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\OrderStatus;
use App\Model\Product;
use App\Model\User;
use App\Model\Province;
use App\Model\City;
use App\Model\District;

class CartController extends Controller
{
    protected $sicepatUsername;
    protected $sicepatApikey;
    protected $originEndpoint;
    protected $destinationEndpoint;
    protected $tariffEndpoint;

    public function __construct()
    {
        parent::__construct();
        $this->sicepatUsername     = env('SICEPAT_API_USERNAME');
        $this->sicepatApikey       = env('SICEPAT_API_KEY');
        $this->originEndpoint      = env('SICEPAT_API_ORIGIN_ENDPOINT');
        $this->destinationEndpoint = env('SICEPAT_API_DESTINATION_ENDPOINT');
        $this->tariffEndpoint      = env('SICEPAT_API_TARIFF_ENDPOINT');
    }

    public function index()
    {
        if (\Auth::check()) {
            // $carts      = \Cache::remember('user-cart-'.\Auth::user()->id, $this->cacheShort, function () {
            //     return Cart::where('user_id', '=', \Auth::user()->id)->get();
            // });
            $carts      = Cart::where('user_id', '=', \Auth::user()->id)->get();
            $totalPrice = 0;
            $quantity   = 0;
            foreach ($carts as $item) {
                $totalPrice += $item->amount * $item->product()->first()->price;
                $quantity   += $item->amount;
            }
            return view('carts.index', [
                'profileNav' => 'cart',
                'carts'      => $carts,
                'qty'        => $quantity,
                'totalPrice' => $totalPrice
            ]);
        } else {
            session()->flash(NOTIF_DANGER, 'You are not logged in!');
            return redirect()->route('home');
        }
    }

    public function store(Request $request) 
    {
        if ($request->ajax()) {
            $response = [
                'status'  => 'failed',
                'message' => 'Invalid Request'
            ];
            if (\Auth::check()) {
                $product = Product::select('id')->where('slug', '=', $request->product)->first();
                if (!empty($product)) {
                    $cart = Cart::firstOrNew([
                        'user_id'            => \Auth::user()->id,
                        'product_id'         => $product->id,
                        'product_variant_id' => $product->images()->first()->id
                    ]);
                    if ($cart->id) {
                        $cart->amount += 1;
                    }
                    $cart->save();
                    $response = [
                        'status'  => 'success',
                        'type'    => 'success',
                        'message' => 'Product has been added',
                    ];
                }
            }
            return response()->json($response); 
        } else {
            $rules = [
                'product'   => 'required|string',
                'quantity'  => 'required|min:1',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->passes()) {
                if ($request->variant == '-') {
                    session()->flash(NOTIF_DANGER, 'Please select the variant');
                } else {
                    $product = Product::select('id')->where('slug', '=', $request->product)->first();
                    if (!empty($product)) {
                        $cart = Cart::firstOrNew([
                            'product_id'         => $product->id,
                            'user_id'            => \Auth::user()->id,
                            'product_variant_id' => $request->variant
                        ]);
                        if ($cart->id) {
                            $cart->amount += $request->quantity;
                        } else {
                            $cart->amount = $request->quantity;
                        }
                        $cart->save();
                        session()->flash(NOTIF_SUCCESS, 'Successfully added to cart!');
                        return redirect()->route('cart');
                    } else {
                        session()->flash(NOTIF_DANGER, 'Invalid Request!');
                    }
                }
            } else {
                session()->flash(NOTIF_DANGER, 'Please recheck your input!');
            }
            return redirect()->back();
        }
    }

    public function remove(Request $request)
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Invalid Request'
        ];
        if (\Auth::check()) {
            $product = Product::select('id')->where('slug', '=', $request->product)->first();
            if (!empty($product)) {
                $cart = Cart::where('user_id', '=', \Auth::user()->id)
                    ->where('product_id', '=', $product->id)
                    ->first();
                if ($cart->id) {
                    $cart->delete();
                    $response = [
                        'status'  => 'success',
                        'type'    => 'success',
                        'message' => 'Product has been removed',
                        'target'  => $request->target
                    ];
                }
            }
        }
        return response()->json($response); 
    }

    public function checkout()
    {
        if (\Auth::check()) {
            $carts               = Cart::where('user_id', '=', \Auth::user()->id)->get();
            $totalPrice          = 0;
            $totalWeight         = 0;
            $quantity            = 0;
            foreach ($carts as $item) {
                $totalPrice  += $item->amount * $item->product()->first()->price;
                $totalWeight += $item->product()->first()->weight;
                $quantity    += $item->amount;
            }
            $sicepatProvinces    = \Cache::get('sicepat-provinces-all');
            if (empty($sicepatProvinces)) {
                $sicepatProvinces = Province::orderBy('name', 'ASC')->pluck('name', 'name');
            }
            return view('carts.checkout', [
                'profileNav'      => 'cart',
                'carts'           => $carts,
                'qty'             => $quantity,
                'totalPrice'      => $totalPrice,
                'totalWeight'     => $totalWeight,
                'provinces'       => $sicepatProvinces,
            ]);
        }
        session()->flash(NOTIF_DANGER, 'Failed to process!');
        return redirect()->back();
    }

    public function cartCheckout(Request $request)
    {
        $rules = [
            'receiver_name'     => 'required|string',
            'receiver_phone'    => 'required|string',
            'receiver_province' => 'required|string',
            'receiver_city'     => 'required|string',
            'receiver_district' => 'required|string',
            'shipping_fee'      => 'required',
            'total_price'       => 'required',
            'payment_method'    => 'required|string',
            'is_dropship'       => '',
            // 'delivery_type'     => 'required|string',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            session()->flash(NOTIF_DANGER, 'Please check receiver data correctly!');
            return redirect()->back()->withInput($request->all());
        }

        if (!is_null($request->dropship) && $request->dropship == 'on') {
            $rules = [
                'shipper_name' => 'required|string',
                'shipper_phone' => 'required|string',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if (!$validator->passes()) {
                session()->flash(NOTIF_DANGER, 'Please check dropshipper data correctly!');
                return redirect()->back()->withInput($request->all());
            }
        }
        $order = new Order($request->all());
        $shippingDetails = explode(' | Rp.', $request->shipping_fee);
        $order->delivery_type = $shippingDetails[0];
        $order->shipping_fee = (float)$shippingDetails[1];
        $order->total_fee = $shippingDetails[1] + $request->totalPrice + rand(111,999);
        $order->user_id = \Auth::user()->id;
        $order->latest_status = Order::ORDER_STATUS_AWAITING_PAYMENT;

        // Get user carts and items to be paid
        $carts = Cart::where('user_id', '=', \Auth::user()->id)->get();

        // Check if wallet balance is enough
        if ($order->payment_method == 'wallet') {
            $totalPrice = 0;
            foreach ($carts as $item) {
                $totalPrice += $item->amount * $item->product()->first()->price;
            }
            if (\Auth::user()->wallet - $totalPrice < 0) {
                session()->flash(NOTIF_DANGER, 'Not enough balance on your wallet!');
                return redirect()->back()->withInput($request->all());
            } 
        }

        // Save order for status mapping
        $district = District::where('code', '=', $request->receiver_district)->first();
        $order->receiver_district = $district->name;
        $order->save();

        // Set order status awaiting for payment for non wallet
        $orderStatus = new OrderStatus([
            'order_id' => $order->id,
            'status'   => $order->latest_status
        ]);
        $orderStatus->save();

        // If wallet payment, set status directly to payment verification status
        if ($order->payment_method == 'wallet') {
            // Cut balance from user wallet
            $user = User::find(\Auth::user()->id);
            $user->wallet -= $totalPrice;
            $user->save();
            // Change order status
            $order->latest_status = Order::ORDER_STATUS_AWAITING_VERIFICATION;
            $orderStatus = new OrderStatus([
                'order_id' => $order->id,
                'status'   => $order->latest_status
            ]);
            $orderStatus->save();     
            $order->save();
        }

        // add to order items
        foreach($carts as $cart) {
            $orderItem = new OrderItem([
                'order_id'           => $order->id,
                'product_id'         => $cart->product_id,
                'product_variant_id' => $cart->product_variant_id,
                'amount'             => $cart->amount,
                'sold_price'         => $cart->product()->first()->price
            ]);
            $orderItem->save();
        }

        // clear cart
        $cart = Cart::where('user_id', '=', \Auth::user()->id);
        $cart->delete();
        
        session()->flash(NOTIF_SUCCESS, 'Order success!');
        return redirect()->route('orders.thanks', [
            'id'       => $order->id
        ]);
    }

    public function thanks($id)
    {
        $order = Order::find($id);
        if (\Auth::check() && 
            !empty($order) && 
            $order->user_id == \Auth::user()->id) {
            $banks = Bank::orderBy('bank_name', 'asc')->get();
            $banksGet['wallet'] = 'Wallet';
            foreach ($banks as $bank) {
                $banksGet[$bank->bank_name.' | '.$bank->account_name ] = '[' . $bank->bank_name.'] '.$bank->account_name . ' | ' . $bank->account_number;
            }
            return view('orders.thanks', [
                'id'       => $order->id,
                'totalFee' => $order->total_fee,
                'banks'    => $banksGet
            ]);
        }
        session()->flash(NOTIF_DANGER, 'You have no privilege!');
        return redirect()->route('home');
    }

    public function thanksConfirm(Request $request)
    {
        $rules = [
            'id'                     => 'required|integer',
            'confirmation_channel'   => 'required|string',
            'confirmation_account'   => 'required|string',
            'confirmation_payer'     => 'sometimes|nullable|string',
            'confirmation_transfer'  => 'required|string',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if (!$validator->passes()) {
            session()->flash(NOTIF_DANGER, 'Please recheck your confirmation inputs');
            return redirect()->back()->withInput();
        }
        $order = Order::find($request->id);
        if (\Auth::user()->id !== $order->user_id) {
            session()->flash(NOTIF_DANGER, 'You have no privilege');
            return redirect()->back()->withInput();
        }
        $order->confirmation_account  = $request->confirmation_account;
        $order->confirmation_channel  = $request->confirmation_channel;
        $order->confirmation_payer    = $request->confirmation_payer;
        $order->confirmation_transfer = $request->confirmation_transfer;
        $order->save();
        session()->flash(NOTIF_SUCCESS, 'Thanks for confirming the order.');
        return redirect()->route('orders');
    }

    public function getCity(Request $request)
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Invalid Request'
        ];
        if (\Auth::check()) {
            $province = Province::where('name', '=', $request->province)->first();
            $cities   = City::orderBy('name', 'ASC')
                ->where('province_id', '=', $province->id)
                ->select('name')
                ->get();
            if (!empty($cities)) {
                $response = [
                    'data'    => $cities,
                    'status'  => 'success',
                    'type'    => 'success',
                ];
            }
        }
        return response()->json($response); 
    }

    public function getDistrict(Request $request)
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Invalid Request'
        ];
        if (\Auth::check()) {
            $city      = City::where('name', '=', $request->city)->first();
            $districts = District::orderBy('name', 'ASC')
                ->where('city_id', '=', $city->id)
                ->select('code', 'name')
                ->get();
            if (!empty($districts)) {
                $response = [
                    'data'    => $districts,
                    'status'  => 'success',
                    'type'    => 'success',
                ];
            }
        }
        return response()->json($response); 
    }

    public function getTariff(Request $request)
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Invalid Request'
        ];
        if (\Auth::check()) {
            if ($request->delivery == 'sicepat') {
                $code     = District::where('code', '=', $request->code)
                    ->select('code')
                    ->first();
                $client   = new \GuzzleHttp\Client();
                $response = $client->request(
                    'GET', 
                    $this->tariffEndpoint . '?api-key=' . $this->sicepatApikey . '&origin=TGR&destination=' .$code->code . '&weight=' . $request->weight
                );
                $result   = json_decode($response->getBody(), true);
                if (!empty($result['sicepat']['results'])) {
                    $data = [];
                    for ($i = 0; $i < count($result['sicepat']['results']); $i++) {
                        if ($result['sicepat']['results'][$i]['service'] == 'REG' ||
                            $result['sicepat']['results'][$i]['service'] == 'BEST') {
                            $data[] = [
                                $result['sicepat']['results'][$i]['service'] . ' | Rp.' . $result['sicepat']['results'][$i]['tariff']
                            ];
                        }
                    }
                    $response = [
                        'data'    => $data,
                        'status'  => 'success',
                        'type'    => 'success',
                    ];
                }
            } else {
                $response = [
                    'data'    => [
                        'Gojek (Ditanggung Pembeli) | Rp. 0'
                    ],
                    'status'  => 'success',
                    'type'    => 'success',
                ];
            }
        }
        return response()->json($response); 
    }

    public function arrayMultiSearch($array, $field, $value)
    {
        foreach($array as $key => $val) {
            if ($val[$field] === $value) {
               return $key;
            }
        }
        return false;
    }

    public function arrayMultiRetrieve($array, $field, $value)
    {
        $temp = [];
        foreach($array as $key => $val) {
            if ($val[$field] === $value) {
               $temp[$key] = $val;
            }
        }
        return $temp;
    }
}
