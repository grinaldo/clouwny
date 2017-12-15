<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Bank;
use App\Model\Order;

class OrderController extends Controller
{
    public function index()
    {
        if (\Auth::user()) {
            $orders = \Cache::remember('order-user-'.\Auth::user()->id, $this->cacheShort, function () {
                return Order::where('user_id', '=', \Auth::user()->id)->paginate(10);
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
            $order = Order::find($request->id);
            if (!empty($order) && \Auth::user()->id == $order->user_id) {
                $order->confirmation_channel       = $request->confirmation_channel;
                $order->confirmation_payer         = $request->confirmation_payer;
                $order->confirmation_account       = $request->confirmation_account;
                $order->confirmation_transfer_date = $request->confirmation_transfer;
                $order->save();
                
                session()->flash(NOTIF_SUCCESS, 'Confirmation submitted!');
                return redirect()->back();
            }
        } else {
            session()->flash(NOTIF_DANGER, 'You have no privilege!');
            return redirect()->route('home');
        }
    }
}
