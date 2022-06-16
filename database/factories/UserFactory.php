<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => $this->faker->word,
            'role_id' => $this->faker->numberBetween(-10000, 10000),
            'association_id' => $this->faker->numberBetween(-10000, 10000),
            'parent_id' => $this->faker->numberBetween(-10000, 10000),
            'class_id' => $this->faker->numberBetween(-10000, 10000),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'mobile_phone' => $this->faker->numberBetween(-10000, 10000),
            'phone' => $this->faker->numberBetween(-10000, 10000),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'email_verified_at' => $this->faker->dateTime(),
            'reset_password_code' => $this->faker->text,
            'status' => $this->faker->word,
            'photo_url' => $this->faker->word,
            'birth_date' => $this->faker->dateTime(),
            'time_zone' => $this->faker->word,
        ];
    }
}
