<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product' => implode(' ', $this->faker->words()),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => rand(1,100),
        ];
    }
}
