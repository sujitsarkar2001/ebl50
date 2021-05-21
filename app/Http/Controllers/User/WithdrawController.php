<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MoneyExchange;
use App\Models\SendShopBalance;
use App\Models\ShopBalance;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdraws = Withdraw::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.index', compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.transaction.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount'         => 'required|numeric',
            'method'         => 'required|string|max:20',
            'holder_name'    => 'required|string|max:20',
            'account_number' => 'required|numeric',
            'date'           => 'required|date'
        ]);

        $user  = auth()->user();

        // check pending withdraw in auth user
        $check = Withdraw::where('user_id', $user->id)->where('status', false)->first();
        
        if ($check) {
            notify()->warning("Already your withdraw amount are pending", "Warning");
            return back();
        }
        
        if ($user->incomeBalance->amount >= setting('withdraw_limit')) {
            
            if ($request->amount >= setting('withdraw_limit')) {
                
                if ($request->amount > $user->incomeBalance->amount) {
                    notify()->warning("Your account has not enough balance", "Warning");
                    return back();
                } 
                else {
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
                    
                    $withdraw = Withdraw::create([
                        'user_id'        => $user->id,
                        'amount'         => $request->amount,
                        'charge'         => $charge,
                        'after_charge'   => $request->amount -$charge,
                        'method'         => $request->method,
                        'holder_name'    => $request->holder_name,
                        'account_number' => $request->account_number,
                        'status'         => false,
                        'date'           => $request->date,
                        'month'          => date('F'),
                        'year'           => date('Y')
                    ]);

                    $user->incomeBalance->update([
                        'amount' => $user->incomeBalance->amount - $request->amount
                    ]);
                    // Add Charge Balance to site income balance
                    \App\Models\SiteIncome::create([
                        'user_id' => $user->id,
                        'amount'  => $charge
                    ]);

            
                    notify()->success("Your withdraw successfully received", "Success");
                    return redirect()->route('withdraw.index');
                }
            } 
            else {
                notify()->warning("Minimum withdraw balance is ".setting('withdraw_limit')." tk", "Warning");
                return back();
            }
        } 
        else {
            notify()->warning('You can withdraw money if the minimum is '. setting('withdraw_limit') .'tk', "Warning");
            return back();
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show(Withdraw $withdraw)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function edit(Withdraw $withdraw)
    {
        return view('user.transaction.form', compact('withdraw'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Withdraw $withdraw)
    // {
    //     $this->validate($request, [
    //         'amount'         => 'required|numeric',
    //         'method'         => 'required|string|max:20',
    //         'holder_name'    => 'required|string|max:20',
    //         'account_number' => 'required|numeric',
    //         'date'           => 'required|date'
    //     ]);

    //     $user = auth()->user();
        
    //     if ($request->amount > $user->incomeBalance->amount) {
            
    //         notify()->warning("Your account has not enough balance", "Warning");
    //         return back();

    //     } else {
    //         if ($request->method == 'Bank') {
    //             $percent = setting('withdraw_charge_in_bank');
    //         } 
    //         else if ($request->method == 'Bkash') {
    //             $percent = setting('withdraw_charge_in_bkash');
    //         }
    //         else if ($request->method == 'Nagad') {
    //             $percent = setting('withdraw_charge_in_nagad');
    //         }
    //         else {
    //             $percent = setting('withdraw_charge_in_rocket');
    //         }
            
    //         $charge = round($percent * ($request->amount / 100), 2);
            
    //         $withdraw->update([
    //             'amount'         => $request->amount,
    //             'charge'         => $charge,
    //             'after_charge'   => $request->amount -$charge,
    //             'method'         => $request->method,
    //             'holder_name'    => $request->holder_name,
    //             'account_number' => $request->account_number
    //         ]);
    
    //         notify()->success("Your withdraw successfully received", "Success");
    //         return redirect()->route('withdraw.index');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }

    // Show income history
    public function showIncomeHistory()
    {
        return view('user.transaction.income-history');
    }

    public function showMoneyExchangeForm()
    {
        return view('user.transaction.money-exchange');
    }

    public function moneyExchange(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric'
        ]);

        $user = auth()->user();
        
        if ($user->incomeBalance->amount >= setting('exchange_limit')) {
            
            if ($request->amount >= setting('exchange_limit')) {
                
                if ($user->incomeBalance->amount >= $request->amount) {
            
                    $percent = setting('money_exchange_charge');
                    $amount  = $request->amount;
                    
                    $charge = round($percent * ($amount / 100), 2);
        
                    MoneyExchange::create([
                        'user_id'      => auth()->id(),
                        'amount'       => $amount,
                        'charge'       => $charge,
                        'after_charge' => $amount - $charge,
                        'status'       => true,
                        'date'         => date('Y-m-d'),
                        'month'        => date('F'),
                        'year'         => date('Y')
                    ]);
        
                    $user->incomeBalance->update([
                        'amount' => $user->incomeBalance->amount - $amount
                    ]);
        
                    $user->shopBalance->update([
                        'amount' => $user->shopBalance->amount + ($amount - $charge)
                    ]);
        
                    // Add Charge Balance to site income balance
                    \App\Models\SiteIncome::create([
                        'user_id' => $user->id,
                        'amount'  => $charge
                    ]);
                    
                    notify()->success("Money exchange request successfully received", "Success");
                    return redirect()->route('money.exchange.list');
        
                } else {
                    notify()->warning("Not enough money to exchange", "Sorry");
                    return back();
                } 
            } 
            else {
                notify()->warning("Minimum money exchange balance is ".setting('exchange_limit')." tk", "Warning");
                return back();
            }
            
            
        }
        else {
            notify()->warning('You can exchange money if the minimum is '. setting('exchange_limit') .'tk', "Warning");
            return back();
        }
        
    }

    // Show All List in Money Exchange for Authenticated User
    public function showMoneyExchangeList()
    {
        $exchanges = MoneyExchange::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.money-exchange-list', compact('exchanges'));
    }


    // Give Shop Balance to Single User
    public function shopBalance()
    {
        $give_shop_balances    = SendShopBalance::where('parent_id', auth()->id())->latest('id')->get();
        $receive_shop_balances = SendShopBalance::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.shop-balance-list', compact('give_shop_balances', 'receive_shop_balances'));
    }

    // Show Give Shop Balance Form
    public function showShopBalanceForm()
    {
        return view('user.transaction.send-shop-balance');
    }

    // Store Shop Balance
    public function storeShopBalance(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:30',
            'amount'   => 'required|numeric'
        ]);
        
        $authUser = User::find(auth()->id());

        if ($request->username == $authUser->username) {
            notify()->warning("You does no send shop balance in your self account", "Wrong Policy");
            return back();
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

                notify()->success("User send shop balance successfully", "Success");
                return redirect()->route('shop.balance');
            }
            else {
                notify()->warning("User not found", "Warning");
                return back();
            }
        } 
        else {
            notify()->warning("Not enough balance in your account", "Warning");
            return back();
        } 
    }
}
