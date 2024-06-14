<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qnaproduct>
 */
class QnaproductFactory extends Factory
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
            ,'qnp_content' => $this->faker->realText(rand(50,200))
            ,'qnp_answer' => $this->faker->realText(rand(50,200))
        ];
    }
}
