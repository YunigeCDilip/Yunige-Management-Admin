<?php

namespace Database\Seeders;

use App\Models\Deliver;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliverTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '新大阪'],
            ['name' => '大東倉庫'],
            ['name' => '吉南倉庫'],
            ['name' => '東京-yamato'],
            ['name' => '桑才倉庫'],
            ['name' => '南港倉庫'],
            ['name' => 'Inter-Assist'],
            ['name' => '相模原']
        ];

        foreach($statuses as $status){
            Deliver::create([
                'name' => $status['name'],
                'active_status' => true
            ]);
        }
    }
}
