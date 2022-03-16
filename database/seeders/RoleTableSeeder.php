<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name'          => 'Employee',
            'guard_name'    => 'web',
            'editable'      => false
        ]);

        Role::create([
            'name'          => 'Admin',
            'guard_name'    => 'web',
            'editable'      => false
        ]);
    }
}
