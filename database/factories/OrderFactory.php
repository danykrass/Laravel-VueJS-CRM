<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => function () {
                return \App\Models\Customer::factory()->create()->id;
            },
            'details' => $this->faker->randomElement(['Shorts', 'T-short', 'Shoes', 'Caps']),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),

        ];
    }
}
