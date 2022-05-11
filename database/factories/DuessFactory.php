<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Duess;

class DuessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Duess::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'dues_type_id' => $this->faker->numberBetween(-10000, 10000),
            'year' => $this->faker->numberBetween(-10000, 10000),
            'month' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
