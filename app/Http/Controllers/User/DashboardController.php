<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\IncomeBalance;
use App\Models\LevelIncome;
use App\Models\Notice;
use App\Models\ShopBalance;
use App\Models\SponsorIncome;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $now       = Carbon::now();
        $weekStart = $now->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        $weekEnd   = $now->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        
        $income_balance = IncomeBalance::where('user_id', Auth::id())->sum('amount');
        $shop_balance   = ShopBalance::where('user_id', Auth::id())->sum('amount');
        
        
        $today_sponsor_income = SponsorIncome::where('user_id', Auth::id())->where('date', date('Y-m-d'))->sum('amount');
        $week_sponsor_income  = SponsorIncome::where('user_id', Auth::id())
                            ->where('date', '>=', $weekStart)
                            ->where('date', '<=', $weekEnd)
                            ->sum('amount');
        $month_sponsor_income = SponsorIncome::where('user_id', Auth::id())->where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_sponsor_income = SponsorIncome::where('user_id', Auth::id())->sum('amount');
        
        // $video = Video::where('date', date('Y-m-d'))->where('year', date('Y'))->first();

        $today_video_income = Auth::user()->videos->where('date', date('Y-m-d'))->sum('rate');
        $week_video_income  = Auth::user()->videos
                            ->where('date', '>=', $weekStart)
                            ->where('date', '<=', $weekEnd)
                            ->sum('rate');
        $month_video_income  = Auth::user()->videos->where('month', date('F'))->where('year', date('Y'))->sum('rate');
        $total_video_income  = Auth::user()->videos->sum('rate');

        $today_generation_income = GenerationIncome::where('user_id', Auth::id())->where('date', date('Y-m-d'))->sum('amount');
        $week_generation_income  = GenerationIncome::where('user_id', Auth::id())
                                ->where('date', '>=', $weekStart)
                                ->where('date', '<=', $weekEnd)
                                ->sum('amount');
        $month_generation_income = GenerationIncome::where('user_id', Auth::id())->where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_generation_income = GenerationIncome::where('user_id', Auth::id())->sum('amount');

        $month_level_income = LevelIncome::where('user_id', Auth::id())->where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_level_income = LevelIncome::where('user_id', Auth::id())->sum('amount');

        $noticed = Notice::where('status', true)->get();

        return view('user.dashboard', compact(
            'income_balance',
            'shop_balance',
            'today_sponsor_income',
            'week_sponsor_income',
            'month_sponsor_income',
            'total_sponsor_income',
            'today_video_income',
            'week_video_income',
            'month_video_income',
            'total_video_income',
            'today_generation_income',
            'week_generation_income',
            'month_generation_income',
            'total_generation_income',
            'month_level_income',
            'total_level_income',
            'noticed'
        ));
    }
}
