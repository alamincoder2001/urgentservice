<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->name(),
            'username'      => $this->faker->unique()->userName(),
            'email'         => $this->faker->unique()->safeEmail(),
            'image'         => "uploads/doctor/download_6370a5d9432e3.png",
            'city_id'       => rand(1, 64),
            'password'      => Hash::make('1'),
            'availability'  => "sun,mon,tue,wed",
            'education'     => $this->faker->sentence(),
            'concentration' => $this->faker->text(100),
            'description'   => $this->faker->text(150),
            'hospital_id'   => $this->faker->numberBetween(1, 1),
            'diagnostic_id' => $this->faker->numberBetween(1, 1),
            'phone'         => $this->faker->numerify('017########'),
            'first_fee'     => $this->faker->numberBetween(600, 1000),
            'second_fee'    => $this->faker->numberBetween(600, 1000),
        ];
    }
}
