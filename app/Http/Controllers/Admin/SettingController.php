<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::get();
        return view('admin.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'single_package'             => 'string|numeric',
            'share_package'              => 'string|numeric',
            'share_package_bonus'        => 'string|numeric',
            'money_exchange_charge'      => 'string|numeric',
            'withdraw_charge_in_bank'    => 'string|numeric',
            'withdraw_charge_in_bkash'   => 'string|numeric',
            'withdraw_charge_in_nagad'   => 'string|numeric',
            'withdraw_charge_in_rocket'  => 'string|numeric',
            'generation_one_income'      => 'string|numeric',
            'generation_one_plus_income' => 'string|numeric',
            'level_one_bonus'            => 'string|numeric',
            'level_two_bonus'            => 'string|numeric',
            'level_three_bonus'          => 'string|numeric',
            'level_four_bonus'           => 'string|numeric',
            'level_five_bonus'           => 'string|numeric',
            'level_six_bonus'            => 'string|numeric',
            'level_seven_bonus'          => 'string|numeric',
            'level_eight_bonus'          => 'string|numeric',
            'level_nine_bonus'           => 'string|numeric',
            'level_ten_bonus'            => 'string|numeric',
            'level_eleven_bonus'         => 'string|numeric',
            'copy_right_text'            => 'string|string|max:255',
        ]);
            
        Setting::updateOrCreate(['name' => 'single_package'], ['value' => $request->get('single_package')]);
        Setting::updateOrCreate(['name' => 'single_package'], ['value' => $request->get('single_package')]);
        Setting::updateOrCreate(['name' => 'share_package'], ['value' => $request->get('share_package')]);
        Setting::updateOrCreate(['name' => 'share_package_bonus'], ['value' => $request->get('share_package_bonus')]);
        Setting::updateOrCreate(['name' => 'money_exchange_charge'], ['value' => $request->get('money_exchange_charge')]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_bank'], ['value' => $request->get('withdraw_charge_in_bank')]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_bkash'], ['value' => $request->get('withdraw_charge_in_bkash')]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_nagad'], ['value' => $request->get('withdraw_charge_in_nagad')]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_rocket'], ['value' => $request->get('withdraw_charge_in_rocket')]);
        Setting::updateOrCreate(['name' => 'generation_one_income'], ['value' => $request->get('generation_one_income')]);
        Setting::updateOrCreate(['name' => 'generation_one_plus_income'], ['value' => $request->get('generation_one_plus_income')]);
        Setting::updateOrCreate(['name' => 'level_one_bonus'], ['value' => $request->get('level_one_bonus')]);
        Setting::updateOrCreate(['name' => 'level_two_bonus'], ['value' => $request->get('level_two_bonus')]);
        Setting::updateOrCreate(['name' => 'level_three_bonus'], ['value' => $request->get('level_three_bonus')]);
        Setting::updateOrCreate(['name' => 'level_four_bonus'], ['value' => $request->get('level_four_bonus')]);
        Setting::updateOrCreate(['name' => 'level_five_bonus'], ['value' => $request->get('level_five_bonus')]);
        Setting::updateOrCreate(['name' => 'level_six_bonus'], ['value' => $request->get('level_six_bonus')]);
        Setting::updateOrCreate(['name' => 'level_seven_bonus'], ['value' => $request->get('level_one_bonus')]);
        Setting::updateOrCreate(['name' => 'level_eight_bonus'], ['value' => $request->get('level_eight_bonus')]);
        Setting::updateOrCreate(['name' => 'level_nine_bonus'], ['value' => $request->get('level_nine_bonus')]);
        Setting::updateOrCreate(['name' => 'level_ten_bonus'], ['value' => $request->get('level_ten_bonus')]);
        Setting::updateOrCreate(['name' => 'level_eleven_bonus'], ['value' => $request->get('level_eleven_bonus')]);
        Setting::updateOrCreate(['name' => 'daily_income_bonus'], ['value' => $request->get('daily_income_bonus')]);
        Setting::updateOrCreate(['name' => 'copy_right_text'], ['value' => $request->get('copy_right_text')]);
        
        notify()->success("Setting successfully updated", "Success");
        return back();
    }

    public function updateLogo(Request $request)
    {
        $this->validate($request, [
            'logo'      => 'nullable|image|max:1024|mimes:jpeg,png,jpg,bmp',
            'auth_logo' => 'nullable|image|max:1024|mimes:jpeg,png,jpg,bmp',
            'favicon'   => 'nullable|image|max:1024|mimes:jpeg,png,jpg,bmp'
        ]);
        
        $logo = $request->file('logo');
        if ($logo) {
            $logoName   = 'logo'.'.'.$logo->getClientOriginalExtension();
            
            if (file_exists('uploads/setting/'.setting('logo'))) {
                unlink('uploads/setting/'.setting('logo'));
            }

            if (!file_exists('uploads/setting')) {
                mkdir('uploads/setting', 0777, true);
            }
            $logo->move(public_path('uploads/setting'), $logoName);

        } else {
            $logoName = setting('logo');
        }

        $auth_logo = $request->file('auth_logo');
        if ($auth_logo) {
            $authLogoName   = 'auth_logo'.'.'.$auth_logo->getClientOriginalExtension();
            
            if (file_exists('uploads/setting/'.setting('auth_logo'))) {
                unlink('uploads/setting/'.setting('auth_logo'));
            }

            if (!file_exists('uploads/setting')) {
                mkdir('uploads/setting', 0777, true);
            }
            $auth_logo->move(public_path('uploads/setting'), $authLogoName);

        } else {
            $authLogoName = setting('auth_logo');
        }

        $favicon = $request->file('favicon');
        if ($favicon) {
            $faviconName   = 'favicon'.'.'.$favicon->getClientOriginalExtension();
            
            if (file_exists('uploads/setting/'.setting('favicon'))) {
                unlink('uploads/setting/'.setting('favicon'));
            }

            if (!file_exists('uploads/setting')) {
                mkdir('uploads/setting', 0777, true);
            }
            $favicon->move(public_path('uploads/setting'), $faviconName);

        } else {
            $faviconName = setting('favicon');
        }

        Setting::updateOrCreate(['name' => 'logo'], ['value' => $logoName]);
        Setting::updateOrCreate(['name' => 'auth_logo'], ['value' => $authLogoName]);
        Setting::updateOrCreate(['name' => 'favicon'], ['value' => $faviconName]);
        
        notify()->success("Application logo successfully updated", "Success");
        return back();
    }
}
