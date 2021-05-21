<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\LevelIncome;
use App\Models\MoneyExchange;
use App\Models\ShareIncome;
use App\Models\SendShopBalance;
use App\Models\ShopBalance;
use App\Models\SiteIncome;
use App\Models\SponsorIncome;
use App\Models\User;
use App\Models\Video;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::latest('id')->get();
        return view('admin.withdraw.index', compact('withdraws'));
    }

    public function edit($id)
    {
        $withdraw = Withdraw::findOrFail($id);
        return view('admin.withdraw.edit', compact('withdraw'));
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
            notify()->error("Sorry Something wrong", "Database Problem");
            return back();
        }
        if (!$user) {
            notify()->error("Member not found", "Not Found");
            return back();
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

            notify()->success("Withdraw successfully updated", "Success");
            return redirect()->route('admin.withdraw.index');


        } else {
            $user->incomeBalance->update([
                'amount' => $user->incomeBalance->amount - $withdraw->amount
            ]);

            $site_income->update([
                'amount' => $site_income->amount + $withdraw->charge
            ]);

            notify()->warning("Member account has not enough balance", "Warning");
            return back();
        }
    }

    // Approved Withdraw
    public function approved($id)
    {
        $withdraw = Withdraw::findOrFail($id);

        $withdraw->update([
            'status' => true
        ]);

        notify()->success("Withdraw amount successfully paid", "Success");
        return back();
    }

    // Show Income History
    public function showIncomeHistory()
    {
        $sponsors      = SponsorIncome::latest('id')->get();
        $levels        = LevelIncome::latest('id')->get();
        $generations   = GenerationIncome::latest('id')->get();
        $site_incomes  = SiteIncome::latest('id')->get();
        $share_incomes = ShareIncome::latest('id')->get();
        $users         = User::get();
        $dailies = [];
        foreach($users as $user) {
            $dailies[$user->id] = $user->videos()->orderBy('id', 'desc')->get();
        }
        // return $dailies;
        return view('admin.withdraw.income-history', compact(
            'share_incomes',
            'site_incomes',
            'generations',
            'sponsors',
            'dailies',
            'users',
            'levels'
        ));
    }

    public function searchIncomeHistory(Request $request)
    {
        // This Filter function define is AppServiceProvider Class...
        $user = User::filter('username', 'username')
                    ->filter('referer_id', 'refer_id')
                    ->first();
        $from_date = $request->filled('from_date');
        $to_date   = $request->filled('to_date');

        if ($from_date != '' && $to_date != '') {

            $sponsors  = $user->sponsorIncomes
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
            $generations  = $user->generationIncomes
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
            $site_incomes = $user->siteIncomes
                        ->where('created_at', '>=', $from_date);
            $share_incomes = $user->shareIncomes
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
            $levels  = $user->levelIncomes
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
            $dailies  = $user->videos
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
        } else {
            $sponsors      = $user->sponsorIncomes()->orderBy('id', 'desc')->get();
            $generations   = $user->generationIncomes()->orderBy('id', 'desc')->get();
            $site_incomes  = $user->siteIncomes()->orderBy('id', 'desc')->get();
            $share_incomes = $user->shareIncomes()->orderBy('id', 'desc')->get();
            $levels        = $user->levelIncomes()->orderBy('id', 'desc')->get();
            $dailies       = $user->videos()->orderBy('id', 'desc')->get();
        }
        
        return redirect(route('admin.withdraw.income.history'))
                ->with('sponsors', $sponsors)
                ->with('generations', $generations)
                ->with('site_incomes', $site_incomes)
                ->with('share_incomes', $share_incomes)
                ->with('levels', $levels)
                ->with('dailies', $dailies)
                ->with('user', $user);
    }

    public function showMoneyExchangeList()
    {
        $exchanges = MoneyExchange::latest('id')->get();
        return view('admin.withdraw.money-exchange-list', compact('exchanges'));
    }

    // Give Shop Balance to Single User
    public function shopBalance()
    {
        $send_shop_balances = SendShopBalance::latest('id')->get();
        return view('admin.withdraw.shop-balance-list', compact('send_shop_balances'));
    }

    // Show Give Shop Balance Form
    public function showShopBalanceForm()
    {
        return view('admin.withdraw.send-shop-balance');
    }

    // Store Shop Balance
    public function storeShopBalance(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:30',
            'amount'   => 'required|numeric'
        ]);

        if ($request->username == auth()->user()->username) {
            notify()->warning("You does no send shop balance in your self account", "Wrong Policy");
            return back();
        }

        $user = User::where('username', $request->username)->first();
        if ($user) {

            SendShopBalance::create([
                'user_id'   => $user->id,
                'parent_id' => auth()->id(),
                'amount'    => $request->amount
            ]);

            $user->shopBalance()->update([
                'amount' => $user->shopBalance->amount + $request->amount
            ]);

            notify()->success("User send shop balance successfully", "Success");
            return redirect()->route('admin.withdraw.shop.balance');
        }
        else {
            notify()->warning("User not found", "Warning");
            return back();
        }
        
    }
}
