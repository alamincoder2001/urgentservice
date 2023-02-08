<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ["Sergeon", "Cardiology", "Pediatric Surgeon", "Plastic Surgery"];
        foreach($data as $d){
            Department::create([
                "name" => $d
            ]);
        }
    }
}
