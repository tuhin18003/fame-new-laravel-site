<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{

    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customers_firstname' => fake()->firstName,
            'customers_lastname' => fake()->lastName,
            'customers_email_address' => fake()->email,
            'customers_password'  => fake()->password(6),
        ];
    }
}
