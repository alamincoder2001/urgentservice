<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\UserAccess;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'group_name' => 'dashboard',
                'permission_name' => [
                    'dashboard.index'
                ]
            ],
            [
                'group_name' => 'blood-donor',
                'permission_name' => [
                    'blood-donor.index',
                    'blood-donor.destroy'
                ]
            ],
            [
                'group_name' => 'client-question',
                'permission_name' => [
                    'client-question.index',
                    'client-question.destroy'
                ]
            ],
            [
                'group_name' => 'setting',
                'permission_name' => [
                    'setting.index',
                    'setting.edit'
                ]
            ],
            [
                'group_name' => 'prescription',
                'permission_name' => [
                    'prescription.index',
                    'prescription.destroy'
                ]
            ],
            [
                'group_name' => 'contact',
                'permission_name' => [
                    'contact.index',
                    'contact.edit'
                ]
            ],
            [
                'group_name' => 'ambulance',
                'permission_name' => [
                    "ambulance.index",
                    "ambulance.create",
                    "ambulance.edit",
                    "ambulance.store",
                    "ambulance.destroy"
                ]
            ],
            [
                'group_name' => 'city',
                'permission_name' => [
                    "city.index",
                    "city.create",
                    "city.edit",
                    "city.destroy"
                ]
            ],
            [
                'group_name' => 'upazila',
                'permission_name' => [
                    "upazila.index",
                    "upazila.create",
                    "upazila.edit",
                    "upazila.destroy"
                ]
            ],
            [
                'group_name' => 'department',
                'permission_name' => [
                    "department.index",
                    "department.create",
                    "department.edit",
                    "department.destroy"
                ]
            ],
            [
                'group_name' => 'diagnostic',
                'permission_name' => [
                    "diagnostic.index",
                    "diagnostic.create",
                    "diagnostic.edit",
                    "diagnostic.store",
                    "diagnostic.destroy"
                ]
            ],
            [
                'group_name' => 'doctor',
                'permission_name' => [
                    "doctor.index",
                    "doctor.create",
                    "doctor.edit",
                    "doctor.store",
                    "doctor.destroy"
                ]
            ],
            [
                'group_name' => 'hospital',
                'permission_name' => [
                    "hospital.index",
                    "hospital.create",
                    "hospital.edit",
                    "hospital.store",
                    "hospital.destroy"
                ]
            ],
            [
                'group_name' => 'investigation',
                'permission_name' => [
                    "investigation.index",
                    "investigation.create",
                    "investigation.edit",
                    "investigation.destroy"
                ]
            ],
            [
                'group_name' => 'privatecar',
                'permission_name' => [
                    'privatecar.index',
                    'privatecar.create',
                    'privatecar.edit',
                    'privatecar.store',
                    'privatecar.destroy'
                ]
            ],
            [
                'group_name' => 'partner',
                'permission_name' => [
                    'partner.index',
                    'partner.create',
                    'partner.edit',
                    'partner.destroy'
                ]
            ],
            [
                'group_name' => 'slider',
                'permission_name' => [
                    "slider.index",
                    "slider.create",
                    "slider.edit",
                    "slider.destroy"
                ]
            ],
            [
                'group_name' => 'test',
                'permission_name' => [
                    "test.index",
                    "test.create",
                    "test.edit",
                    "test.destroy"
                ]
            ],
            [
                'group_name' => 'user',
                'permission_name' => [
                    'user.index',
                    'user.create',
                    'user.edit',
                    'user.destroy'
                ]
            ],
        ];

        foreach ($permissions as $permission) {
            foreach ($permission['permission_name'] as $permissionName) {
                Permission::create(['permissions' => $permissionName, 'group_name' => $permission['group_name']]);
            }
        }

        $allPermissions = Permission::all();
        foreach ($allPermissions as $perm) {
            UserAccess::create([
                'user_id'     => 1,
                'group_name'  => $perm->group_name,
                'permissions' => $perm->permissions,
            ]);
        }
    }
}
