<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => '상품이름'
            ,'price' => $this->faker->numberBetween(10, 50)*1000
            ,'count' => $this->faker->numberBetween(10, 200)
            ,'ml' => $this->faker->numberBetween(250, 1000)
            ,'img' => '/img/best.png'
            ,'info' => '/img/bag.png'
        ];
    }
}
