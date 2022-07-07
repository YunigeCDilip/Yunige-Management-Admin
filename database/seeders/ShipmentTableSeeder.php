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
            '海上',
            '※過去登録用',
            'A.I.F. COMPANY',
            'apex',
            'Aramex',
            'CWWS',
            'DDP',
            'DHL',
            'DSV',
            'EMS',
            'FATES',
            'FEDEX',
            'FEG LOGISTICS',
            'MJロジスティック',
            'OCS',
            'PANTOS',
            'SANYO LOGISTICS',
            'SITC',
            'TNT',
            'Unnamed record',
            'UPS',
            'USPS',
            'XXXXXXX------toll',
            'YGL',
            'アートバンライン',
            'エイチアンドフレンズ',
            'エコ配',
            'エフシースタンダードロジックス',
            'オーシャンロジスティック',
            'キャリアーセントラル',
            'キューネ＆ナーゲル',
            'グロー',
            'ゲートウェイ',
            'スコアジャパン',
            'その他',
            'チャーター　トールエクスプレス',
            'ヤマト',
            'ゆうパック',
            '他社FEDEX',
            '佐川',
            '共立トランスポート',
            '大信相互運輸',
            '大港運輸',
            '日通NECロジスティック',
            '福山通運',
            '美濃物流',
            '自社FBA',
            '西濃',
            '路線　トールエクスプレス',
            '関空エアシステム',
            '阪神協同作業'
        ];
        
        foreach($data as $status){
            ShipmentMethod::create([
                'name' => $status
            ]);
        }
    }
}
