<?php

namespace App\Domains;

/**
 * Class WarehouseDomain
 *
 * Register all static data required for warehouse
 */
class WarehouseDomain
{
    /**
     * List all status in airtable
     * 
     * @return array
     */
    public static function status()
    {
        return [
            "到着待ち",
            "到着済み",
            "到着したが不明",
            "税関手続き中",
            "通関済みだが到着不明"
        ];
    }

    /**
     * List all pic in airtable
     * 
     * @return array
     */
    public static function pic()
    {
        return[
            "網本",
            "村田",
            "杉生",
            "井上",
            "辻",
            "崔",
            "三村",
            "梶村",
            "深水",
            "Bian",
            "井上（剣）",
            "アニール",
            "高津"
        ];
    }

    /**
     * List all deliver in airtable
     * 
     * @return array
     */
    public static function deliver()
    {
        return[
            "新大阪",
            "大東倉庫",
            "吉南倉庫",
            "東京-yamato",
            "桑才倉庫",
            "南港倉庫",
            "Inter-Assist",
            "相模原"
        ];
    }

    /**
     * List all cat in airtable
     * 
     * @return array
     */
    public static function cat()
    {
        return[
            "化粧品",
            "食品",
            "雑貨",
            "その他",
            "IOR",
            "ユニゲ自社仕入",
            "PSE確認",
            "化粧品原料"
        ];
    }

    /**
     * List all container in airtable
     * 
     * @return array
     */
    public static function container()
    {
        return[
            "20フィート",
            "40フィート",
            "混載"
        ];
    }

    /**
     * List all job in airtable
     * 
     * @return array
     */
    public static function job()
    {
        return[
            "FBA",
            "FNSKU",
            "食品",
            "薬事",
            "PSE",
            "輸入者",
            "期限",
            "セット",
            "転送",
            "保管",
            "袋入れ",
            "サンプル",
            "数量検品必要",
            "数量検品不要",
            "amazon返品分",
            "現状不明"
        ];
    }

    /**
     * List all incomplete in airtable
     * 
     * @return array
     */
    public static function incomplete()
    {
        return[
            "FBA",
            "FNSKU",
            "食品",
            "薬事",
            "PSE",
            "輸入者",
            "期限",
            "セット",
            "目隠し",
            "転送",
            "完了",
            "保管",
            "継続出荷",
            "単品検品",
            "袋入れ"
        ];
    }

    /**
     * List all reason in airtable
     * 
     * @return array
     */
    public static function reason()
    {
        return[
            "FBA",
            "FNSKU",
            "食品",
            "薬事",
            "PSE",
            "輸入者",
            "期限",
            "セット",
            "目隠し",
            "転送",
            "完了",
            "保管",
            "継続出荷",
            "単品検品",
            "袋入れ"
        ];
    }

    /**
     * List all warehousePic in airtable
     * 
     * @return array
     */
    public static function warehousePic()
    {
        return[
            "村木",
            "三村",
            "二宮",
            "高野",
            "BtoC",
            "茂崎"
        ];
    }

    /**
     * List all deliveryPlace in airtable
     * 
     * @return array
     */
    public static function deliveryPlace()
    {
        return[
            "大松運送",
            "桑才倉庫",
            "大松倉庫",
            "吉南倉庫",
            "吉南",
            "大松",
            "プロップ",
            "南港"
        ];
    }

    /**
     * List all pickDirection in airtable
     * 
     * @return array
     */
    public static function pickDirection()
    {
        return[
            "乙仲依頼",
            "自社引取-CWWS",
            "自社引取-コンテナ",
            "TOLL",
            "TAIHO",
            "共立トランポ"
        ];
    }

    /**
     * List all trkInput in airtable
     * 
     * @return array
     */
    public static function trkInput()
    {
        return[
            "乙仲依頼",
            "自社引取-CWWS",
            "自社引取-コンテナ",
            "TOLL",
            "TAIHO",
            "共立トランポ"
        ];
    }

    /**
     * List all inboundStatus in airtable
     * 
     * @return array
     */
    public static function inboundStatus()
    {
        return[
            "w詳細入力済",
            "w詳細未入力",
            "事前準備完了（引取可能）",
            "※過去分仕分け用（w詳細未入力だが請求完了過去分）"
        ];
    }

    /**
     * Format data for wdata post/put api
     * 
     * @param Request $request
     * 
     * @return array
     */
    public static function format($request)
    {
        $invoices = [];
        if(count($request['invoice']) > 0){
            foreach($request->invoice as $index => $file){
                if ($request->isMethod('post')) {
                    $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'invoice-'.$file->getClientOriginalName());  
                    $file->storeAs('public/wdata', $fileName);
                    $invoices[$index]['url'] = url('storage/wdata').'/'.$fileName;
                }else{
                    $invoices[$index]['id'] = $file;
                }
            }
        }
        $permits = [];
        if(count($request['permit']) > 0){
            foreach($request->permit as $index => $file){
                if ($request->isMethod('post')) {
                    $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'permit-'.$file->getClientOriginalName());  
                    $file->storeAs('public/wdata', $fileName);
                    $permits[$index]['url'] = url('storage/wdata').'/'.$fileName;
                }else{
                    $permits[$index]['id'] = $file;
                }
            }
        }
        return [
            'data'            => [
                'invoice'       => $invoices,
                'status'        => $request->status,
                'client'        => $request->client,
                'trkNo'         => $request->trkNo,
                'pic'           => $request->pic,
                'cat'           => $request->cat,
                'importPermit'  => $permits,
                'carrier'       => $request->carrier,
                'permitNo'      => $request->permitNo,
                'memoK'         => $request->memoK
            ],
            'typecast'          => (bool)($request->has('typecast')) ? $request->typecast : config('services.airtable.typecast')
        ];
    }
}
