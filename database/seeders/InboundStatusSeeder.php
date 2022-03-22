<?php

namespace Database\Seeders;

use App\Models\InboundStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InboundStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'w詳細入力済', 'color' => 'primary'],
            ['name' => 'w詳細未入力', 'color' => 'success'],
            ['name' => '事前準備完了（引取可能）', 'color' => 'danger'],
            ['name' => '※過去分仕分け用（w詳細未入力だが請求完了過去分）', 'color' => 'warning'],
        ];

        foreach($statuses as $status){
            InboundStatus::create([
                'ja_name' => $status['name'],
                'color' => $status['color']
            ]);
        }
    }
}
