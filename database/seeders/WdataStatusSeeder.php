<?php

namespace Database\Seeders;

use App\Models\WdataStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WdataStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '到着待ち', 'color' => 'primary'],
            ['name' => '到着済み', 'color' => 'success'],
            ['name' => '到着したが不明', 'color' => 'danger'],
            ['name' => '税関手続き中', 'color' => 'warning'],
            ['name' => '通関済みだが到着不明', 'color' => 'blue'],
        ];

        foreach($statuses as $status){
            WdataStatus::create([
                'ja_name' => $status['name'],
                'color' => $status['color']
            ]);
        }
    }
}
