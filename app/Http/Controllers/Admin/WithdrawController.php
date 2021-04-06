<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\LevelIncome;
use App\Models\MoneyExchange;
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
            'holder_name'    => 'required|string|max:20',
            'account_number' => 'required|numeric',
            'date'           => 'required|date'
        ]);

        $withdraw = Withdraw::findOrFail($id);
        
        if ($request->amount > $withdraw->user->incomeBalance->amount) {
            
            notify()->warning("Member account has not enough balance", "Warning");
            return back();

        } else {
            $withdraw->update([
                'holder_name'    => $request->holder_name,
                'account_number' => $request->account_number,
                'date'           => $request->date
            ]);
    
            notify()->success("Withdraw successfully updated", "Success");
            return redirect()->route('admin.withdraw.index');
        }
    }

    // Approved Withdraw
    public function approved($id)
    {
        $withdraw = Withdraw::findOrFail($id);

        $withdraw->user->incomeBalance->update([
            'amount' => $withdraw->user->incomeBalance->amount - $withdraw->amount
        ]);

        $withdraw->update([
            'status' => true
        ]);

        // Add Charge Balance to site income balance
        SiteIncome::create([
            'user_id' => $withdraw->user->id,
            'amount'  => $withdraw->charge
        ]);

        notify()->success("Withdraw amount successfully paid", "Success");
        return back();
    }

    // Show Income History
    public function showIncomeHistory()
    {
        $sponsors     = SponsorIncome::latest('id')->get();
        $levels       = LevelIncome::latest('id')->get();
        $generations  = GenerationIncome::latest('id')->get();
        $site_incomes = SiteIncome::latest('id')->get();
        $users = User::all();
        $dailies = [];
        foreach($users as $user) {
            $dailies[$user->id] = $user->videos;
        }
        
        return view('admin.withdraw.income-history', compact(
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
                        ->where('created_at', '>=', $from_date)
                        ->where('created_at', '<=', $to_date);
            $levels  = $user->levelIncomes
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
            $dailies  = $user->videos
                        ->where('date', '>=', $from_date)
                        ->where('date', '<=', $to_date);
        } else {
            $sponsors     = $user->sponsorIncomes;
            $generations  = $user->generationIncomes;
            $site_incomes = $user->siteIncomes;
            $levels       = $user->levelIncomes;
            $dailies      = $user->videos;
        }
        
        
        return redirect(route('admin.withdraw.income.history'))
                ->with('sponsors', $sponsors)
                ->with('generations', $generations)
                ->with('site_incomes', $site_incomes)
                ->with('levels', $levels)
                ->with('dailies', $dailies);
    }

    public function showMoneyExchangeList()
    {
        $exchanges = MoneyExchange::latest('id')->get();
        return view('admin.withdraw.money-exchange-list', compact('exchanges'));
    }

    // Approved Money Exchange Request
    public function approvedMoneyExchange($id)
    {
        $exchange = MoneyExchange::findOrFail($id);

        $exchange->user->incomeBalance->update([
            'amount' => $exchange->user->incomeBalance->amount - $exchange->amount
        ]);

        $exchange->user->shopBalance->update([
            'amount' => $exchange->user->shopBalance->amount + $exchange->amount
        ]);

        // Add Charge Balance to site income balance
        SiteIncome::create([
            'user_id' => $exchange->user->id,
            'amount'  => $exchange->charge
        ]);

        $exchange->update([
            'status' => true
        ]);

        notify()->success("Money exchange request successfully approved", "Success");
        return back();
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
