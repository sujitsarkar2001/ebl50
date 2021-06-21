<?php

namespace Database\Seeders;

use App\Models\IncomeBalance;
use App\Models\ShopBalance;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserInfo::create([
            'user_id' => rand(2, 4000),
            'country' => 'Bangladesh',
            'gender'  => 'Male'
        ]);
        IncomeBalance::create([
            'user_id'  => rand(2, 4000)
        ]);

        ShopBalance::create([
            'user_id'  => rand(2, 4000)
        ]);
    }
}
