<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\District;

class DistrictFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = District::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'country_id' => $this->faker->numberBetween(-10000, 10000),
            'state_id' => $this->faker->numberBetween(-10000, 10000),
            'city_id' => $this->faker->numberBetween(-10000, 10000),
            'name' => $this->faker->name,
        ];
    }
}
