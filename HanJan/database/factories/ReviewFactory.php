<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'u_id' => 1
            ,'orp_id' => 1
            ,'re_content' => $this->faker->realText(rand(10,100))
            ,'re_star' => $this->faker->numberBetween(1, 5)
        ];
    }
}
