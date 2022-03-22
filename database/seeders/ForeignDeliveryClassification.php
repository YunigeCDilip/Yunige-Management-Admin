<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForeignDeliveryClassification as Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ForeignDeliveryClassification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'シッパー', 'color' => 'primary'],
            ['name' => '製造工場', 'color' => 'warning'],
            ['name' => '依頼顧客', 'color' => 'danger'],
        ];

        foreach($statuses as $status){
            Model::create([
                'name' => $status['name'],
                'color' => $status['color']
            ]);
        }
    }
}
