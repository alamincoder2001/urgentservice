<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class DiagnosticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'            => $this->faker->name(),
            'username'        => $this->faker->unique()->userName(),
            'email'           => $this->faker->unique()->safeEmail(),
            'image'           => "uploads/diagnostic/2147436.jpg",
            'city_id'         => rand(1, 64),
            'password'        => Hash::make('1'),
            'address'         => "Shyamoli",
            'map_link'        => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.319252082497!2d90.36651021445692!3d23.807243992520444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c12cd2f41ad5%3A0xd4eb5975120eaff0!2sMirpur%2010%20Bus%20Stand!5e0!3m2!1sen!2sbd!4v1662967833091!5m2!1sen!2sbd" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'phone'           => $this->faker->numerify('017########'),
            'diagnostic_type' => "non-government",
        ];
    }
}
