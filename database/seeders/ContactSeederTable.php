<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            "email" => "contact@gmail.com",
            "phone" => "01737484046",
            "address" => "mirpur-10",
            "map_link" => "map_link",
            "image"   => "uploads/contact/6463384.png"
        ]);
    }
}
