<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sponsor_id' => rand(2, 4000),
            'placement_id' => rand(2, 4000),
            'direction' => rand(1, 3),
            'level' => 'No Level',
            'next_level_bonus' => date('Y-m-d'),
            'name' => $this->faker->name,
            'referer_id' => rand(pow(10, 5-1), pow(10, 5)-1),
            'username' => $this->faker->username,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'is_admin' => false,
            'is_approved' => $this->faker->boolean,
            'joining_date' => $this->faker->date(),
            'joining_month' => $this->faker->date('F'),
            'joining_year' => $this->faker->date('Y'),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
