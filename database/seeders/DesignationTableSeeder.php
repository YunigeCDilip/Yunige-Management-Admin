<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "KOREA",
            "国際部",
            "管理部",
            "案件担当者",
            "管理者",
            "JAPAN",
            "倉庫",
            "EC",
            "営業",
            "K-factry",
            "大東",
            "南港",
            "ラベル作成依頼者",
            "請求書作成"
        ];
        
        foreach($data as $status){
            Designation::create([
                'name' => $status
            ]);
        }
    }
}
