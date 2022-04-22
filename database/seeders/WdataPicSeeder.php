<?php

namespace Database\Seeders;

use App\Models\WdataPic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WdataPicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '網本', 'color' => 'primary'],
            ['name' => '村田', 'color' => 'success'],
            ['name' => '杉生', 'color' => 'danger'],
            ['name' => '井上', 'color' => 'warning'],
            ['name' => '辻', 'color' => 'blue'],
            ['name' => '崔', 'color' => 'info'],
            ['name' => '三村', 'color' => 'dark'],
            ['name' => '梶村', 'color' => 'blue'],
            ['name' => '深水', 'color' => 'pink'],
            ['name' => 'Bian', 'color' => 'secondary'],
            ['name' => '井上（剣）', 'color' => 'light'],
            ['name' => 'アニール', 'color' => 'primary'],
            ['name' => '高津', 'color' => 'pink'],
        ];

        foreach($statuses as $status){
            WdataPic::create([
                'name' => $status['name'],
                'color' => $status['color']
            ]);
        }
    }
}
