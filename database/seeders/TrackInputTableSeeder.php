<?php

namespace Database\Seeders;

use App\Models\TrackInput;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackInputTableSeeder extends Seeder
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
            '自社引取-コンテナ',
            'TOLL',
            'TAIHO',
            '共立トランポ',
            '自社引取-CWWS'
        ];
        
        foreach($data as $status){
            TrackInput::create([
                'name' => $status
            ]);
        }
    }
}
