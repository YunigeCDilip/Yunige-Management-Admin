<?php

namespace Database\Seeders;

use App\Models\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContainerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '20フィート',
            '40フィート',
            '混載',
        ];
        
        foreach($data as $status){
            Container::create([
                'name' => $status
            ]);
        }
    }
}
