<?php

namespace Database\Seeders;

use App\Models\WdataCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WdataCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
           "化粧品",
           "食品",
           "雑貨",
           "その他",
           "IOR",
           "ユニゲ自社仕入",
           "PSE確認",
           "化粧品原料"
        ];

        foreach($data as $status){
            WdataCategory::create([
                'name' => $status
            ]);
        }
    }
}
