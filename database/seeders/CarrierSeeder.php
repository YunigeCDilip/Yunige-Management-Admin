<?php

namespace Database\Seeders;

use App\Models\Carrier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "新大阪",
            "大東倉庫",
            "吉南倉庫",
            "東京-yamato",
            "桑才倉庫",
            "南港倉庫",
            "Inter-Assist",
            "相模原"
        ];
        
        foreach($data as $status){
            Carrier::create([
                'name' => $status
            ]);
        }
    }
}
