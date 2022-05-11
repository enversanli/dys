<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DailyPoll;

class DailyPollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyPoll::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'class_id' => $this->faker->numberBetween(-10000, 10000),
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
