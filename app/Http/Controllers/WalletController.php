<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Wallet;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = Wallet::where('user_id', '=', \Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('wallets.index', [
            'transactions' => $transactions
        ]);
    }

    public function transaction(Request $request)
    {
        $rules = [
            'type'   => 'required|string',
            'amount' => 'required|min:1',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if($request->type == Wallet::TRANSACTION_WITHDRAWAL &&
               \Auth::user()->wallet < $request->amount) {
                session()->flash(NOTIF_DANGER, 'Invalid Amount!');
                return redirect()->back()->withInput($request->all());
            }

            $transaction = new Wallet($request->all());
            $transaction->status = Wallet::TRANSACTION_STATUS_ON_PROCESS;
            $transaction->user_id = \Auth::user()->id;
            $transaction->save();

            session()->flash(NOTIF_SUCCESS, 'Request succesfully submitted!');
            return redirect()->route('profile');
        }
        session()->flash(NOTIF_DANGER, 'Please recheck your inputs');
        return redirect()->back()->withInput($request->all());
    }
}
