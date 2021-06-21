<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MoneyExchange;
use App\Models\SiteIncome;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $withdraws = Withdraw::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.index', compact('withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.transaction.withdraw');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'Already your withdraw amount are pending',
            ]);
        }

        if ($user->incomeBalance->amount >= setting('withdraw_limit')) {

            if ($request->amount >= setting('withdraw_limit')) {

                if ($request->amount > $user->incomeBalance->amount) {
                    return response()->json([
                        'alert'   => 'Warning',
                        'message' => 'Your account has not enough balance',
                    ]);
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

                    Withdraw::create([
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
                    SiteIncome::create([
                        'user_id' => $user->id,
                        'amount'  => $charge
                    ]);

                    return response()->json([
                        'alert'   => 'Success',
                        'message' => 'Your withdraw successfully received',
                    ]);
                }
            }
            else {
                return response()->json([
                    'alert'   => 'Warning',
                    'message' => 'Minimum withdraw balance is '.setting('withdraw_limit').' tk'
                ]);
            }
        }
        else {
            return response()->json([
                'alert'   => 'Warning',
                'message' => 'You can withdraw money if the minimum is '.setting('withdraw_limit').' tk'
            ]);
        }
    }

    public function showMoneyExchangeForm()
    {
        return view('user.transaction.exchange');
    }

    public function moneyExchange(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|integer'
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
                    SiteIncome::create([
                        'user_id' => $user->id,
                        'amount'  => $charge
                    ]);
                    return response()->json([
                        'alert' => 'Success',
                        'message' => 'Money exchange request successfully received'
                    ]);

                } else {
                    return response()->json([
                        'alert' => 'Warning',
                        'message' => 'Money exchange request successfully received'
                    ]);
                }

            } else {
                return response()->json([
                    'alert' => 'Warning',
                    'message' => 'Minimum money exchange balance is '.setting('exchange_limit').' tk'
                ]);
            }

        } else {
            return response()->json([
                'alert' => 'Warning',
                'message' => 'You can exchange money if the minimum is '.setting('exchange_limit').' tk'
            ]);
        }
    }

}
