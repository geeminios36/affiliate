<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WalletCollection;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function balance($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json([
            'balance' => $user->balance
        ]);
    }

    public function walletRechargeHistory($id)
    {
        return new WalletCollection(Wallet::where('user_id', $id)->latest()->get());
    }

    public function processPayment(Request $request)
    {
        $order = new OrderController;
        $user = User::where('id',$request->user_id)->first();

        if ($user->balance >= $request->grand_total) {
            $user->balance -= $request->grand_total;
            $user->tenacy_id = get_tenacy_id_for_query(); $user->save();

            return $order->processOrder($request);
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'The order was not completed becuase the paymeent is invalid'
            ]);
        }
    }
}
