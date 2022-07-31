<?php

namespace Database\Factories;

use App\Models\StudentClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentClass>
 */
class StudentClassFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentClass::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'association_id' => $this->faker->numberBetween(0,1000),
            'teacher_id' => $this->faker->numberBetween(0,1000),
            'creator_id' => $this->faker->numberBetween(0,1000),
            'key' => $this->faker->numberBetween(0,1000),
            'name' => $this->faker->name,
            'description' => $this->faker->address,
        ];
    }
}
