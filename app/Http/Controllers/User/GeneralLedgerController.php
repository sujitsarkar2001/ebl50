<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyIncome;
use App\Models\Fund;
use App\Models\GenerationIncome;
use App\Models\IncomeBalance;
use App\Models\LevelIncome;
use App\Models\MoneyExchange;
use App\Models\SendShopBalance;
use App\Models\ShopBalance;
use App\Models\SponsorIncome;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralLedgerController extends Controller
{
    /**
     * show general ledger
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        if(!$request->ajax()){
            return redirect('/');
        }
        $income_balance    = IncomeBalance::where('user_id', auth()->id())->sum('amount');
        $shop_balance      = ShopBalance::where('user_id', Auth::id())->sum('amount');
        $sponsor_income    = SponsorIncome::where('user_id', Auth::id())->sum('amount');
        // $daily_income      = Auth::user()->videos->sum('rate');
        $daily_income      = DailyIncome::where('user_id', Auth::id())->sum('amount');
        $level_income      = LevelIncome::where('user_id', Auth::id())->sum('amount');
        $generation_income = GenerationIncome::where('user_id', Auth::id())->sum('amount');
        $withdraw_amount   = Withdraw::where('user_id', Auth::id())->sum('amount');
        $money_exchange    = MoneyExchange::where('user_id', Auth::id())->sum('amount');
        $transfer_amount     = SendShopBalance::where('parent_id', Auth::id())->sum('amount');
        $admin_ids           = User::where('is_admin', true)->pluck('id');
        $company_transfer_in = SendShopBalance::where('user_id', Auth::id())->whereIn('parent_id', $admin_ids)->sum('amount');
        $member_transfer_in  = SendShopBalance::where('user_id', Auth::id())->whereNotIn('parent_id', $admin_ids)->sum('amount');

        // $video = Video::where('date', date('Y-m-d'))->where('year', date('Y'))->first();

        return view('user.transaction.general-ledger', compact(
            'income_balance',
            'shop_balance',
            'sponsor_income',
            'generation_income',
            'daily_income',
            'level_income',
            'withdraw_amount',
            'money_exchange',
            'transfer_amount',
            'company_transfer_in',
            'member_transfer_in'
        ));
    }

    /**
     * show sponsor income data
     *
     * @param  mixed $request
     * @return void
     */
    public function sponsorIncome(Request $request)
    {
        if(!$request->ajax()){
            return back();
        }
        $sponsor_incomes = SponsorIncome::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.income.sponsor', compact('sponsor_incomes'));
    }

    /**
     * show generation income data
     *
     * @param  mixed $request
     * @return void
     */
    public function generationIncome(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->to('/');
        }
        $generation_incomes = GenerationIncome::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.income.generation', compact('generation_incomes'));
    }

    /**
     * show daily income data
     *
     * @param  mixed $request
     * @return void
     */
    public function dailyIncome(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->to('/');
        }
        $daily_incomes = DailyIncome::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.income.daily', compact('daily_incomes'));
    }

    /**
     * show daily income data
     *
     * @param  mixed $request
     * @return void
     */
    public function levelIncome(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->to('/');
        }
        $level_incomes = LevelIncome::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.income.level', compact('level_incomes'));
    }

    /**
     * show withdraw expense data
     *
     * @param  mixed $request
     * @return void
     */
    public function withdrawExpense(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->to('/');
        }
        $withdraws = Withdraw::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.expense.withdraw', compact('withdraws'));
    }

    /**
     * show exchange expense data
     *
     * @param  mixed $request
     * @return void
     */
    public function exchangeExpense(Request $request)
    {
        if(!$request->ajax()){
            return redirect()->to('/');
        }
        $exchanges = MoneyExchange::where('user_id', auth()->id())->latest('id')->get();
        return view('user.transaction.expense.exchange', compact('exchanges'));
    }

    /**
     * show add func form
     */
    public function  showAddFundForm()
    {
        return view('user.transaction.fund.form');
    }

    /**
     * store fund
     * @param Request $request
     */
    public function storeFund(Request $request)
    {
        $this->validate($request, [
            'method'         => 'required|string|max:255',
            'transaction_id' => 'required|string|max:255',
            'number'         => 'required|string|max:255',
            'amount'         => 'required|integer'
        ]);

        Fund::create([
            'user_id' => auth()->id(),
            'method' => $request->method,
            'transaction_id' => $request->transaction_id,
            'number' => $request->number,
            'amount' => $request->amount
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Successfully receive your fund'
        ]);
    }
    
    /**
     * show fund history
     *
     * @return void
     */
    public function showFundHistory()
    {
        $funds = Fund::where('user_id', auth()->id())->latest()->get();
        return view('user.transaction.fund.index', compact('funds'));
    }
}
