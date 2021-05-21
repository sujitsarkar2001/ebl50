<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(['name' => 'single_package'], ['value' => 1000]);
        Setting::updateOrCreate(['name' => 'share_package'], ['value' => 10000]);
        Setting::updateOrCreate(['name' => 'withdraw_limit'], ['value' => 100]);
        Setting::updateOrCreate(['name' => 'exchange_limit'], ['value' => 100]);
        Setting::updateOrCreate(['name' => 'share_package_bonus'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'money_exchange_charge'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_bank'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_bkash'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_nagad'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'withdraw_charge_in_rocket'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'generation_one_income'], ['value' => 100]);
        Setting::updateOrCreate(['name' => 'generation_one_plus_income'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'level_one_bonus'], ['value' => 10]);
        Setting::updateOrCreate(['name' => 'level_two_bonus'], ['value' => 20]);
        Setting::updateOrCreate(['name' => 'level_three_bonus'], ['value' => 30]);
        Setting::updateOrCreate(['name' => 'level_four_bonus'], ['value' => 5000]);
        Setting::updateOrCreate(['name' => 'level_five_bonus'], ['value' => 7000]);
        Setting::updateOrCreate(['name' => 'level_six_bonus'], ['value' => 9000]);
        Setting::updateOrCreate(['name' => 'level_seven_bonus'], ['value' => 10000]);
        Setting::updateOrCreate(['name' => 'level_eight_bonus'], ['value' => 15000]);
        Setting::updateOrCreate(['name' => 'level_nine_bonus'], ['value' => 20000]);
        Setting::updateOrCreate(['name' => 'level_ten_bonus'], ['value' => 30000]);
        Setting::updateOrCreate(['name' => 'level_eleven_bonus'], ['value' => 31000]);
        Setting::updateOrCreate(['name' => 'daily_income_bonus'], ['value' => 5]);
        Setting::updateOrCreate(['name' => 'copy_right_text'], ['value' => 'Copyright © 2014-2020 AdminLTE.io. All rights reserved.']);
        Setting::updateOrCreate(['name' => 'logo'], ['value' => 'default.png.']);
        Setting::updateOrCreate(['name' => 'auth_logo'], ['value' => 'default.png.']);
        Setting::updateOrCreate(['name' => 'favicon'], ['value' => 'default.png.']);
    }
}
