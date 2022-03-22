<?php

namespace Database\Seeders;

use App\Models\MovementConfirmation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovementConfirmationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '据置', 'color' => 'primary'],
            ['name' => '移行', 'color' => 'warning'],
            ['name' => '廃止', 'color' => 'danger'],
        ];

        foreach($statuses as $status){
            MovementConfirmation::create([
                'name' => $status['name'],
                'color' => $status['color']
            ]);
        }
    }
}
