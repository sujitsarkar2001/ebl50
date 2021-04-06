<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenerationIncome;
use App\Models\IncomeBalance;
use App\Models\LevelIncome;
use App\Models\ShopBalance;
use App\Models\SiteIncome;
use App\Models\SponsorIncome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Direction;

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
        
        $site_income = SiteIncome::sum('amount');

        $income_balance = IncomeBalance::sum('amount');

        $shop_balance   = ShopBalance::sum('amount');
        
        $total_member        = User::where('is_admin', false)->count();
        $total_active_member = User::where('is_admin', false)->where('is_approved', true)->count();
        $total_left_member   = User::where('direction', Direction::Left)->count();
        $total_middle_member = User::where('direction', Direction::Middle)->count();
        $total_right_member  = User::where('direction', Direction::Right)->count();
        
        $today_sponsor_income = SponsorIncome::where('date', date('Y-m-d'))->sum('amount');
        $week_sponsor_income  = SponsorIncome::where('date', '>=', $weekStart)
                            ->where('date', '<=', $weekEnd)
                            ->sum('amount');
        $month_sponsor_income = SponsorIncome::where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_sponsor_income = SponsorIncome::sum('amount');
        
        $today_video_income = User::with('videos')
                    ->get()->reduce( function($carry, $item){
            return $carry + $item->videos->where('date', date('Y-m-d'))->sum('rate');
        });
        $week_video_income = User::with('videos')
                    ->get()->reduce( function($carry, $item){
            $now       = Carbon::now();
            $weekStart = $now->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            $weekEnd   = $now->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');
        
                    return $carry + $item->videos
                        ->where('date', '>=', $weekStart)
                        ->where('date', '<=', $weekEnd)
                        ->sum('rate');
        });
        $month_video_income = User::with('videos')
                    ->get()->reduce( function($carry, $item){
            return $carry + $item->videos->where('month', date('F'))->where('year', date('Y'))->sum('rate');
        });
        $total_video_income = User::with('videos')
                    ->get()->reduce( function($carry, $item){
            return $carry + $item->videos->sum('rate');
        });

        $today_generation_income = GenerationIncome::where('date', date('Y-m-d'))->sum('amount');
        $week_generation_income  = GenerationIncome::where('date', '>=', $weekStart)
                                ->where('date', '<=', $weekEnd)
                                ->sum('amount');
        $month_generation_income = GenerationIncome::where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_generation_income = GenerationIncome::sum('amount');
        
        $month_level_income = LevelIncome::where('month', date('F'))->where('year', date('Y'))->sum('amount');
        $total_level_income = LevelIncome::sum('amount');

        $today_single_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('single_package'))
                                    ->where('joining_date', date('Y-m-d'))
                                    ->sum('register_package');
        $week_single_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('single_package'))
                                    ->where('joining_date', '>=', $weekStart)
                                    ->where('joining_date', '<=', $weekEnd)
                                    ->sum('register_package');
        $year_single_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('single_package'))
                                    ->where('joining_year', date('Y'))
                                    ->sum('register_package');
        $total_single_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('single_package'))
                                    ->sum('register_package');

        $today_share_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('share_package'))
                                    ->where('joining_date', date('Y-m-d'))
                                    ->sum('register_package');
        $week_share_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('share_package'))
                                    ->where('joining_date', '>=', $weekStart)
                                    ->where('joining_date', '<=', $weekEnd)
                                    ->sum('register_package');
        $year_share_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('share_package'))
                                    ->where('joining_year', date('Y'))
                                    ->sum('register_package');
        $total_share_package_income = User::where('is_approved', true)
                                    ->where('register_package', '>=', setting('share_package'))
                                    ->sum('register_package');
        
        return view('admin.dashboard', compact(
            'total_member',
            'total_active_member',
            'total_left_member',
            'total_middle_member',
            'total_right_member',
            'site_income',
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
            'today_single_package_income',
            'week_single_package_income',
            'year_single_package_income',
            'total_single_package_income',
            'today_share_package_income',
            'week_share_package_income',
            'year_share_package_income',
            'total_share_package_income'
        ));

    }
}
