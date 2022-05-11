<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DuesType;

class DuesTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DuesType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => $this->faker->word,
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(-10000, 10000),
            'type' => $this->faker->word,
            'status' => $this->faker->word,
        ];
    }
}
