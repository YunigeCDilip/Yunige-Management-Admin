<?php

namespace Database\Seeders;

use App\Models\Transfer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           "大東倉庫",
           "南港倉庫",
           "新大阪",
           "桑才倉庫",
           "東京-yamato",
           "吉南倉庫",
           "inter-Assist"
        ];
        
        foreach($data as $status){
            Transfer::create([
                'name' => $status
            ]);
        }
    }
}
