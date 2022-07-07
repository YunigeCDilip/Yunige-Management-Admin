<?php

namespace App\Domains;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
     * List all arrivalPlaces in airtable
     * 
     * @return array
     */
    public static function arrivalPlaces()
    {
        return[
            "新大阪",
            "大東倉庫",
            "加納倉庫",
            "南港(OSAKA)",
            "相模原(TOKYO)",
            "川崎倉庫",
            "東京-yamato",
            "Inter-Assist",
            "桑才倉庫",
            "吉南倉庫",
            "その他",
            "ITALY",
            "DUBAI",
            "UK",
        ];
    }
    
    /**
     * List all labelingStatus in airtable
     * 
     * @return array
     */
    public static function labelingStatus()
    {
        return[
            "不明(新規s薬事のため)",
            "日本貼付",
            "海外貼付",
            "雑貨（貼付不要)"
        ];
    }
    
    /**
     * List all workInstructions in airtable
     * 
     * @return array
     */
    public static function workInstructions()
    {
        return[
            "数量検品必要",
            "数量検品不要",
            "転送",
            "サンプル",
            "FBA",
            "食品",
            "薬事",
            "PSE",
            "保管",
            "別途(イレギュラ指示)",
            "【商品別】作業指示(イレギュラー)"
        ];
    }

    /**
     * Format data for wdata post api
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
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'invoice-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('invoices', $fileName, 's3');
                    $invoices[$index]['url'] = Storage::disk('s3')->url('invoices/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        $permits = [];
        if(count($request['permit']) > 0){
            foreach($request->permit as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'permit-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('permits', $fileName, 's3');
                    $permits[$index]['url'] = Storage::disk('s3')->url('permits/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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



    /**
     * Format data for wdata put api
     * 
     * @param Request $request
     * 
     * @return array
     */
    public static function formatUpdateRequest($request)
    {
        $invoices = [];
        if($request->has('invoice') && count($request['invoice']) > 0){
            foreach($request->invoice as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'invoice-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('invoices', $fileName, 's3');
                    $invoices[$index]['url'] = Storage::disk('s3')->url('invoices/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                } 
            }
        }
        if($request->has('invoice_ids')){
            $ids = [];
            foreach($request->invoice_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $invoices = array_merge($ids, $invoices);
        }
        $permits = [];
        if($request->has('permit') && count($request['permit']) > 0){
            foreach($request->permit as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'permit-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('permits', $fileName, 's3');
                    $permits[$index]['url'] = Storage::disk('s3')->url('permits/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('permit_ids')){
            $ids = [];
            foreach($request->permit_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $permits = array_merge($ids, $permits);
        }
        $packings = [];
        if($request->has('packing') && count($request['packing']) > 0){
            foreach($request->packing as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'packing-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('packings', $fileName, 's3');
                    $packings[$index]['url'] = Storage::disk('s3')->url('packings/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('packing_ids')){
            $ids = [];
            foreach($request->packing_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $packings = array_merge($ids, $packings);
        }
        $AN = [];
        if($request->has('AN') && count($request['AN']) > 0){
            foreach($request->AN as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'AN-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('AN', $fileName, 's3');
                    $AN[$index]['url'] = Storage::disk('s3')->url('AN/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('an_ids')){
            $ids = [];
            foreach($request->an_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $AN = array_merge($ids, $AN);
        }
        $BL = [];
        if($request->has('BL') && count($request['BL']) > 0){
            foreach($request->BL as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'BL-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('BL', $fileName, 's3');
                    $BL[$index]['url'] = Storage::disk('s3')->url('BL/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('bl_ids')){
            $ids = [];
            foreach($request->bl_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $BL = array_merge($ids, $BL);
        }

        $devlivery = [];
        if($request->has('DO') && count($request['DO']) > 0){
            foreach($request->DO as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'DO-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('DO', $fileName, 's3');
                    $devlivery[$index]['url'] = Storage::disk('s3')->url('DO/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('do_ids')){
            $ids = [];
            foreach($request->do_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $devlivery = array_merge($ids, $devlivery);
        }

        $arrivals = [];
        if($request->has('arrival_pic') && count($request['arrival_pic']) > 0){
            foreach($request->arrival_pic as $index => $file){
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'pic-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('arrivals', $fileName, 's3');
                    $arrivals[$index]['url'] = Storage::disk('s3')->url('arrivals/'.$fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
        }
        if($request->has('arrival_pic_ids')){
            $ids = [];
            foreach($request->arrival_pic_ids as $index => $id){
                $ids[$index]['id'] = $id;
            }
            $arrivals = array_merge($ids, $arrivals);
        }
        return [
            'data'            => [
                'invoice'           => $invoices,
                'status'            => $request->status,
                'client'            => $request->client,
                'trkNo'             => $request->trkNo,
                'pic'               => $request->pic,
                'cat'               => $request->cat,
                'importPermit'      => $permits,
                'carrier'           => $request->carrier,
                'permitNo'          => $request->permitNo,
                'memoK'             => $request->memoK,
                'packingList'       => $packings,
                'AN'                => $AN,
                'job'               => $request->job,
                'plateNumber'       => $request->plateNumber,
                'inboundStatus'     => $request->inboundStatus,
                'panelCheck'        => ($request->panelCheck) ? true : false,
                // 'arrivalCTN'        => $request->arrivalCTN,
                // 'outerdamage'       => $request->outerdamage,
                'arrivalPic'        => $arrivals,
                'arrivalPicURL'     => $request->arrivalPicURL,
                'BL'                => $BL,
                'DO'                => $devlivery,
            ], 
            'typecast'              => (bool)($request->has('typecast')) ? $request->typecast : config('services.airtable.typecast')
        ];
    }
}
