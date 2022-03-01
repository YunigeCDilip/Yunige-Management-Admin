<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'access.permissions' => [
                ['name' => 'manage.role', 'display_name' => 'Manage Role', 'guard_name' => 'web', 'key' => 'access'],
                ['name' => 'manage.user', 'display_name' => 'Manage User', 'guard_name' => 'web', 'key' => 'access']
            ],
            'warehouse.permissions' => [
                ['name' => 'manage.warehouse.data', 'display_name' => 'Manage Warehouse Data', 'guard_name' => 'web', 'key' => 'warehouse']
            ]
        ];

        foreach ($permissions as $p) {

            foreach ($p as $permission) {

                Permission::firstOrCreate($permission);

            }
        }
    }
}
