<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendController extends Controller
{
    public function index()
    {
        if (\Auth::user()) {
            $totalUser      = \App\Model\User::count();
            $orders         = \App\Model\Order::count();
            $orderFulfilled = \App\Model\Order::where('latest_status', '=', Order::ORDER_STATUS_SHIPPED)
                ->orWhere('latest_status', '=', Order::ORDER_STATUS_CANCELLED)
                ->orWhere('latest_status', '=', Order::ORDER_STATUS_REFUNDED)
                ->count();
            $contacts       = \App\Model\Contact::count();
            $wallets        = \App\Model\Wallet::count();
            $walletFulfill  = \App\Model\Wallet::where('status', '=', 'on-process')->count();
            $zeroStock      = \App\Model\Product::where('stock', '=', 0)->count();
            return view('admins.backends.index', [
                'users'     => $totalUser,
                'orders'    => $orders,
                'ov'        => $orderFulfilled,
                'contacts'  => $contacts,
                'wallets'   => $wallets,
                'wv'        => $walletFulfill,
                'zeroStock' => $zeroStock
            ]);
        }
        return redirect()->route('backend.login');
    }

}
