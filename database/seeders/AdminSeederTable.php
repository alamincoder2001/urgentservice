<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "name" => "Admin",
            "username" => "admin",
            "role" => "Supper Admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make(1)
        ]);
    }
}
