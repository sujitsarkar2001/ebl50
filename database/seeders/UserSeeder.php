<?php

namespace Database\Seeders;

use App\Models\IncomeBalance;
use App\Models\ShopBalance;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '01749699156',
            'is_admin' => true,
            'is_approved' => true,
            'joining_date' => date('Y-m-d'),
            'joining_month' => date('F'),
            'joining_year' => date('Y'),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10)
        ]);

        $user = User::updateOrCreate([
            'level' => 'No Level',
            'next_level_bonus' => date('Y-m-d'),
            'name' => 'User',
            'referer_id' => 11111,
            'username' => 'user',
            'email' => 'user@gmail.com',
            'phone' => '01303851066',
            'is_admin' => false,
            'is_approved' => true,
            'joining_date' => date('Y-m-d'),
            'joining_month' => date('F'),
            'joining_year' => date('Y'),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10)
        ]);

        UserInfo::create([
            'user_id' => $user->id,
            'country' => 'Bangladesh',
            'gender'  => 'Male'
        ]);

        IncomeBalance::create([
            'user_id'  => $user->id
        ]);

        ShopBalance::create([
            'user_id'  => $user->id
        ]);
    }
}
