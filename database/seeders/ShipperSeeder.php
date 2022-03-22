<?php

namespace Database\Seeders;

use App\Models\Shipper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['shipper_name' => 'amazon_korea'],
            ['shipper_name' => 'amazon_US'],
            ['shipper_name' => 'amazon_china'],
            ['shipper_name' => 'amazon_taiwan'],
            ['shipper_name' => 'japan'],
            ['shipper_name' => 'yamato_us'],
            ['shipper_name' => 'yamato_korea'],
            ['shipper_name' => 'amazon_india'],
            ['shipper_name' => 'amazon_singapore'],
            ['shipper_name' => 'yamato_eu'],
            ['shipper_name' => '物販'],
            ['shipper_name' => 'yamato_taiwan'],
            ['shipper_name' => 'yamato_china'],
            ['shipper_name' => 'amazon_eu'],
            ['shipper_name' => 'amazon_Thailand'],
            ['shipper_name' => 'First Choice Shipping'],
            ['shipper_name' => 'yamato_singapore']
        ];

        foreach($statuses as $status){
            Shipper::create($status);
        }
    }
}
