<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SendShopBalance;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{    
    /**
     * company transfer to authenticated user balance history
     *
     * @param  mixed $request
     * @return void
     */
    public function companyTransfer(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->to('/');
        }
        $admin_ids = User::where('is_admin', true)->pluck('id');
        $balances  = SendShopBalance::where('user_id', auth()->id())->whereIn('parent_id', $admin_ids)->latest('id')->get();
        return view('user.transaction.shop.company-transfer', compact('balances'));
    }

    /**
     * member transfer to authenticated user balance history
     *
     * @param  mixed $request
     * @return void
     */
    public function memberTransfer(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->to('/');
        }
        $admin_ids = User::where('is_admin', true)->pluck('id');
        $balances  = SendShopBalance::where('user_id', auth()->id())->whereNotIn('parent_id', $admin_ids)->latest('id')->get();
        return view('user.transaction.shop.member-transfer', compact('balances'));
    }

    /**
     * show authenticated user transfer to other user user account balance history
     *
     * @param  mixed $request
     * @return void
     */
    public function transfer(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->to('/');
        }
        $balances  = SendShopBalance::where('parent_id', auth()->id())->latest('id')->get();
        return view('user.transaction.shop.transfer', compact('balances'));
    }
 
    /**
     * show send shop balance form
     *
     * @return void
     */
    public function sendShopBalanceForm()
    {
        return view('user.transaction.send-shop-balance');
    }

    // Store Shop Balance
    public function storeSendShopBalance(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:30',
            'amount'   => 'required|numeric'
        ]);
        
        $authUser = User::find(auth()->id());

        if ($request->username == $authUser->username) {
            return response()->json([
                'alert' => 'Warning',
                'message' => 'You does no send shop balance in your self account'
            ]);
        }
        

        if ($authUser->shopBalance->amount >= $request->amount) {

            $user = User::where('username', $request->username)->first();
            
            if ($user) {

                SendShopBalance::create([
                    'user_id'   => $user->id,
                    'parent_id' => auth()->id(),
                    'amount'    => $request->amount
                ]);
                
                // Update requested user amount
                $user->shopBalance()->update([
                    'amount' => $user->shopBalance->amount + $request->amount
                ]);
                
                // Update auth user requested amount
                $authUser->shopBalance()->update([
                    'amount' => $authUser->shopBalance->amount - $request->amount
                ]);
                
                return response()->json([
                    'alert' => 'Success',
                    'message' => 'User send shop balance successfully'
                ]);
            }
            else {
                return response()->json([
                    'alert' => 'Warning',
                    'message' => 'User not found'
                ]);
            }
        } 
        else {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Not enough balance in your account'
            ]);
        } 
    }
  
    /**
     * Shop Balance Send and receive history
     *
     * @return void
     */
    public function history()
    {
        $send_shop_balances    = SendShopBalance::where('parent_id', auth()->id())->latest('id')->get();
        $receive_shop_balances = SendShopBalance::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.shop-balance-list', compact('send_shop_balances', 'receive_shop_balances'));
    }
}
