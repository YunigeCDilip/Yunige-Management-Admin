<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'FBA',
            'FNSKU',
            '食品',
            '薬事',
            'PSE',
            '輸入者',
            '期限',
            'セット',
            '目隠し',
            '転送',
            '完了',
            '保管',
            '継続出荷',
            '単品検品',
            '袋入れ'
        ];

        foreach($data as $status){
            Reason::create([
                'reason' => $status
            ]);
        }
    }
}
