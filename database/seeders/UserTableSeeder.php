<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => "Yunige Administrator",
            'email'             => "yunige.service@info.com",
            'email_verified_at' => now(),
            'password'          => bcrypt('admin'),
            'remember_token'    => Str::random(10),
            'is_super_admin'    => true,
            'active_status'     => true,
        ]);

        // User::factory(50)->create();
    }
}
