<?php

namespace Database\Seeders;

use App\Models\Localization;
use Illuminate\Database\Seeder;

class LocalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['locale' => 'en', 'country' => 'English', 'status' => true],
            ['locale' => 'ja', 'country' => 'Japanese', 'status' => true],
            ['locale' => 'ko', 'country' => 'Korean', 'status' => true],
        ];
        foreach($array as $key => $value){
            Localization::create([
                'locale'        => $value['locale'],
                'country'       => $value['country'],
                'active_status' => $value['status']
            ]);
        }
    }
}
