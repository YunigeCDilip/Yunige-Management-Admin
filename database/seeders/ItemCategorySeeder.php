<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '化粧品'],
            ['name' => '食品'],
            ['name' => '雑貨'],
            ['name' => '化粧品原料'],
            ['name' => 'PSE']
        ];

        foreach($statuses as $status){
            ItemCategory::create($status);
        }
    }
}
