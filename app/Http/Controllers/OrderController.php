<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Bank;
use App\Model\Order;
use App\Model\OrderStatus;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        if (\Auth::user()) {
            $orders = \Cache::remember('order-user-'.\Auth::user()->id, $this->cacheShort, function () {
                return Order::where('user_id', '=', \Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
            });
            return view('orders.index', [
                'profileNav' => 'order',
                'orders'     => $orders
            ]);
        } else {
            session()->flash(NOTIF_DANGER, 'You have no privilege!');
            return redirect()->route('home');
        }
    }

    public function show($orderid)
    {
        if (!   \Auth::check()) {
            \Session::flash(NOTIF_WARNING, 'Anda Belum Login!');
            return redirect()->route('home');
        }
        $order = \Cache::remember(
            'order-detail-'.$orderid.'-user-'.\Auth::user()->id,
            $this->cacheShort,
            function () use ($orderid) {
                return Order::find($orderid);
            }
        );
        if (empty($order) || $order->user_id !== \Auth::user()->id) {
            session()->flash(NOTIF_DANGER, 'Invalid order!');
            return redirect()->route('orders');
        }
        $banks = Bank::orderBy('bank_name', 'asc')->get();
        $banksGet['wallet'] = 'Wallet';
        foreach ($banks as $bank) {
            $banksGet[$bank->bank_name.' | '.$bank->account_name ] = '[' . $bank->bank_name.'] '.$bank->account_name . ' | ' . $bank->account_number;
        }
        return view('orders.show', [
            'order' => $order,
            'banks' => $banksGet
        ]);
    }

    public function confirm(Request $request)
    {
        if (\Auth::user()) {
            $rules = [
                'confirmation_channel'   => 'required|string',
                'confirmation_payer'     => 'required|string',
                'confirmation_account'   => 'required|string',
                'confirmation_transfer'  => 'required|string',
                'confirmation_date'      => 'required',
            ];
            $validator = \Validator::make($request->all(), $rules);

            if (!$validator->passes()) {
                \Session::flash(NOTIF_DANGER, 'Data Konfirmasi Tidak Lengkap!');
                return redirect()->back()->withInput();
            }

            $order = Order::find($request->id);
            $now = Carbon::now();
            if (!empty($order) && \Auth::user()->id == $order->user_id) {
                $order->confirmation_channel       = $request->confirmation_channel;
                $order->confirmation_payer         = $request->confirmation_payer;
                $order->confirmation_account       = $request->confirmation_account;
                $order->payment_method             = $request->confirmation_transfer;
                $order->confirmation_transfer_date = Carbon::createFromFormat('m/d/Y', $request->confirmation_date);
                $order->latest_status              = Order::ORDER_STATUS_AWAITING_VERIFICATION;
                if (!empty($request->confirmation_image)) {
                    if (!empty($order->confirmation_image) && 
                        file_exists(public_path($order->confirmation_image))
                    ) {
                        unlink(public_path($order->confirmation_image));
                    }
                    $file = $request->file('confirmation_image');
                    $filename = \Auth::user()->username.'-'.$now->format('Ymdhis').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('files'), $filename);
                    $order->confirmation_image = 'files/'.$filename;
                }
                $order->save();

                $orderStatus = OrderStatus::firstOrCreate([
                    'order_id' => $order->id,
                    'status'   => Order::ORDER_STATUS_AWAITING_VERIFICATION
                ]);
                
                session()->flash(NOTIF_SUCCESS, 'Confirmation submitted!');
                return redirect()->back();
            }
        } else {
            session()->flash(NOTIF_DANGER, 'You have no privilege!');
            return redirect()->route('home');
        }
    }
}
