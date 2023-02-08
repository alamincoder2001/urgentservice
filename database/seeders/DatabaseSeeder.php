<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeederTable::class);
        $this->call(SettingSeederTable::class);
        $this->call(ContactSeederTable::class);
        $this->call(DepartmentSeederTable::class);
        $this->call(PermissionSeeder::class);
        \App\Models\Hospital::factory(1)->create();
        \App\Models\Diagnostic::factory(1)->create();
        \App\Models\Ambulance::factory(1)->create();
        \App\Models\Doctor::factory(1)->create();
    }
}
