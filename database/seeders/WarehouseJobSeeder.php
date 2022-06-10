<?php

namespace Database\Seeders;

use App\Models\WarehouseJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarehouseJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           "FBA",
           "FNSKU",
           "食品",
           "薬事",
           "PSE",
           "輸入者",
           "期限",
           "セット",
           "転送",
           "保管",
           "袋入れ",
           "サンプル",
           "数量検品必要",
           "数量検品不要",
           "amazon返品分",
           "現状不明"
         ];
         
        foreach($data as $status){
            WarehouseJob::create([
                'name' => $status
            ]);
        }
    }
}
