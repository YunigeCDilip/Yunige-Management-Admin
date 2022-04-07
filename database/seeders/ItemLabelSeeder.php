<?php

namespace Database\Seeders;

use App\Models\ItemLabel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => '有'],
            ['name' => '未完成'],
            ['name' => '申請のみ'],
            ['name' => 'パッケージ印刷'],
            ['name' => '雑貨'],
            ['name' => '無'],
            ['name' => '作成済み保留'],
            ['name' => '過去分使用不可'],
            ['name' => '成分保留中'],
            ['name' => 'サンプル保留'],
            ['name' => '保留'],
            ['name' => '使用不可'],
            ['name' => '※毎回変更する必要あり'],
            ['name' => '※別成分版表品あり注意'],
            ['name' => '※複数パターンあり'],
            ['name' => '案件NG'],
            ['name' => 'FNSKU別で必要'],
            ['name' => '※要確認（類似ラベルあり）'],
            ['name' => '※外は発送袋のためセット中身のみラベルあり'],
            ['name' => '本輸入抜き取り後作成'],
        ];

        foreach($statuses as $status){
            ItemLabel::create($status);
        }
    }
}
