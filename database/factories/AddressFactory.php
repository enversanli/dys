<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'association_id' => $this->faker->numberBetween(-10000, 10000),
            'country_id' => $this->faker->numberBetween(-10000, 10000),
            'state_id' => $this->faker->numberBetween(-10000, 10000),
            'city_id' => $this->faker->numberBetween(-10000, 10000),
            'district_id' => $this->faker->numberBetween(-10000, 10000),
            'postal_code' => $this->faker->postcode,
            'line' => $this->faker->word,
        ];
    }
}
