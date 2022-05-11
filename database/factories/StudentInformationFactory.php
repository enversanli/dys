<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\StudentInformation;

class StudentInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'school' => $this->faker->word,
            'grade' => $this->faker->numberBetween(-10000, 10000),
            'note' => $this->faker->text,
            'father_full_name' => $this->faker->word,
            'mother_full_name' => $this->faker->word,
        ];
    }
}
