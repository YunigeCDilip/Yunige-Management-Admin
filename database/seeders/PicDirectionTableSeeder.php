<?php

namespace Database\Seeders;

use App\Models\PickDirection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PicDirectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '乙仲依頼',
            '自社引取-CWWS',
            '自社引取-コンテナ',
            'TOLL',
            'TAIHO',
            '共立トランポ'
        ];
        
        foreach($data as $status){
            PickDirection::create([
                'name' => $status
            ]);
        }
    }
}
