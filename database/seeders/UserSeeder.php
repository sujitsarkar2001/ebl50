<?php

namespace Database\Seeders;

use App\Models\User;
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


        $user->userInfo()->create([
            'country' => 'Bangladesh',
            'gender' => 'Male',
        ]);

        
        \App\Models\IncomeBalance::create([
            'user_id'  => $user->id
        ]);
        \App\Models\ShopBalance::create([
            'user_id'  => $user->id
        ]);
    }
}
