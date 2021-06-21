<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeBalance;
use App\Models\SendIncomeBalance;
use App\Models\SendShopBalance;
use App\Models\SiteIncome;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        return view('admin.withdraw.index');
    }

    public function show($id)
    {
        $withdraw = Withdraw::where('id', $id)->where('status', false)->firstOrFail();
        return response()->json($withdraw);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'amount'         => 'required|numeric',
            'method'         => 'required|string|max:20',
            'holder_name'    => 'required|string|max:20',
            'account_number' => 'required|numeric',
            'date'           => 'required|date'
        ]);

        $withdraw    = Withdraw::findOrFail($id);
        $site_income = SiteIncome::where('user_id', $withdraw->user_id)->where('amount', $withdraw->charge)->whereDate('created_at', date('Y-m-d', strtotime($withdraw->created_at)))->first();
        $user        = User::find($withdraw->user_id);
        
        if (!$site_income) {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Sorry Something wrong, Database Problem'
            ]);
        }
        if (!$user) {
            return response()->json([
                'alert'   => 'Error',
                'message' => 'Member not found'
            ]);
        }

        $user->incomeBalance->update([
            'amount' => $user->incomeBalance->amount + $withdraw->amount
        ]);

        $site_income->update([
            'amount' => $site_income->amount - $withdraw->charge
        ]);
        
        if ($user->incomeBalance->amount >= $request->amount) {
            
            if ($request->method == 'Bank') {
                $percent = setting('withdraw_charge_in_bank');
            } 
            else if ($request->method == 'Bkash') {
                $percent = setting('withdraw_charge_in_bkash');
            }
            else if ($request->method == 'Nagad') {
                $percent = setting('withdraw_charge_in_nagad');
            }
            else {
                $percent = setting('withdraw_charge_in_rocket');
            }
            
            $charge = round($percent * ($request->amount / 100), 2);

            $withdraw->update([
                'amount'         => $request->amount,
                'charge'         => $charge,
                'after_charge'   => $request->amount -$charge,
                'method'         => $request->method,
                'holder_name'    => $request->holder_name,
                'account_number' => $request->account_number,
                'date'           => $request->date,
            ]);
            
            $user->incomeBalance->update([
                'amount' => $user->incomeBalance->amount - $request->amount
            ]);

            $site_income->update([
                'amount' => $site_income->amount + $charge
            ]);
            return response()->json([
                'alert'   => 'Success',
                'message' => 'Withdraw successfully updated'
            ]);

        } else {
            $user->incomeBalance->update([
                'amount' => $user->incomeBalance->amount - $withdraw->amount
            ]);

            $site_income->update([
                'amount' => $site_income->amount + $withdraw->charge
            ]);
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Member account has not enough balance'
            ]);
        }
    }

    // Approved Withdraw
    public function approved($id)
    {
        $withdraw = Withdraw::where('id', $id)->where('status', false)->firstOrFail();
        $withdraw->status = true;
        $withdraw->save();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Withdraw amount successfully paid'
        ]);
    }

    // Show Income History
    public function showIncomeHistory()
    {
        return view('admin.withdraw.income-history');
    }

    public function showMoneyExchangeList()
    {
        return view('admin.withdraw.money-exchange');
    }

    /**
     * shop balance history
     *
     * @return void
     */
    public function shopBalance()
    {
        return view('admin.withdraw.shop-balance');
    }

    /**
     * store shop balance
     *
     * @param  mixed $request
     * @return void
     */
    public function storeShopBalance(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:30',
            'amount'   => 'required|numeric'
        ]);

        if ($request->username == auth()->user()->username) {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'You does no send shop balance in your self account'
            ]);
        }

        $user = User::where('is_admin', false)->where('username', $request->username)->first();
        if ($user) {

            SendShopBalance::create([
                'user_id'   => $user->id,
                'parent_id' => auth()->id(),
                'amount'    => $request->amount
            ]);

            $user->shopBalance()->update([
                'amount' => $user->shopBalance->amount + $request->amount
            ]);

            return response()->json([
                'alert'   => 'Success',
                'message' => 'User send shop balance successfully'
            ]);
        }
        else {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'User not found'
            ]);
        }
        
    }

    
    /**
     * income balance history
     *
     * @return void
     */
    public function incomeBalance()
    {
        return view('admin.withdraw.income-balance');
    }
    
    /**
     * income balance info
     *
     * @return void
     */
    public function incomeBalanceInfo()
    {
        $users = User::where('is_admin', false)->where('is_approved', true)->get(['id', 'username']);
        return response()->json($users);
    }

    /**
     * store income balance
     *
     * @param  mixed $request
     * @return void
     */
    public function storeIncomeBalance(Request $request)
    {
        $this->validate($request, [
            'type'       => 'required|max:30',
            'username'   => 'nullable|array',
            'username.*' => 'integer',
            'amount'      => 'required|integer'
        ]);

        if ($request->type == 'Individual') {
            $users = User::where('is_admin', false)->whereIn('id', $request->username)->where('is_approved', true)->get();
        
        } else {
            $users = User::where('is_admin', false)->where('is_approved', true)->get();
        }
        
        foreach ($users as $user)
        {
            SendIncomeBalance::create([
                'user_id' => $user->id,
                'amount'  => $request->amount,
                'details' => $request->details
            ]);
            
            $income_balance = IncomeBalance::where('user_id', $user->id)->first(); 
            $income_balance->amount = $income_balance->amount + $request->amount;
            $income_balance->save();
        }

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Successfully send income balance in user amount'
        ]);
    }
    
    /**
     * show income balance details
     *
     * @param  mixed $id
     * @return void
     */
    public function showIncomeBalance($id)
    {
        $data = SendIncomeBalance::findOrFail($id, ['details']);

        return response()->json($data);
    }
}
