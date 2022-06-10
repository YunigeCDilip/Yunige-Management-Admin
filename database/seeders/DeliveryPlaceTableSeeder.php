<?php

namespace Database\Seeders;

use App\Models\DeliveryPlace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliveryPlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '大松運送',
            '桑才倉庫',
            '大松倉庫',
            '吉南倉庫',
            '吉南',
            '大松',
            'プロップ',
            '南港',
        ];
        
        foreach($data as $status){
            DeliveryPlace::create([
                'name' => $status
            ]);
        }
    }
}
