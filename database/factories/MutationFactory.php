<?php

namespace Database\Factories;

use App\Models\Mutation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MutationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mutation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(10000, 999999),
            'balance' => $this->faker->numberBetween(10000, 999999),
            'description' => $this->faker->text(30),
            'type' => $this->faker->randomElement(Mutation::TYPES),
            'received_at' => $this->faker->dateTime(),
        ];
    }
}
