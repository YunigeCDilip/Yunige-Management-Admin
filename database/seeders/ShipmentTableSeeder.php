<?php

namespace Database\Seeders;

use App\Models\ShipmentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '航空',
            '海上'
        ];
        
        foreach($data as $status){
            ShipmentMethod::create([
                'name' => $status
            ]);
        }
    }
}
