<?php

namespace App\Domains;

/**
 * Class SdataDomain
 *
 * Register all static data required for Items and its SDATA
 */
class SdataDomain
{
    /**
     * List all caseInCharge in airtable
     * 
     * @return array
     */
    public static function caseInCharge()
    {
        return [
            "網本",
            "村田",
            "杉生",
            "井上",
            "崔",
            "辻",
            "馬",
            "黒原",
            "清水",
            "深水",
            "蔡松我",
            "ベン",
            "アニール",
            "カリナ",
            "井上剣"
        ];
    }

    /**
     * List all priority in airtable
     * 
     * @return array
     */
    public static function priority()
    {
        return[
            "大至急",
            "至急",
            "通常",
            "案件完了",
            "案件NG",
            "保留中",
            "過去登録",
            "音信不通",
            "不明（雑貨？食品？）"
        ];
    }

    /**
     * List all ingredientProgress in airtable
     * 
     * @return array
     */
    public static function ingredientProgress()
    {
        return[
            "成分未入手",
            "成分過去分使用",
            "成分チェック中",
            "再成分チェック中",
            "仮完了（最終確認中）",
            "成分お客様確認中",
            "成分完了",
            "成分NG",
            "成分修正中",
            "一部未確定",
            "申請のみ案件",
            "※過去登録用",
            "不明",
            "食品",
            "ＰＳＥ",
            "成分他社確認"
        ];
    }

    /**
     * List all notificationProgress in airtable
     * 
     * @return array
     */
    public static function notificationProgress()
    {
        return[
            "届出完了",
            "届出情報依頼中（お客様情報待ち）",
            "届出情報入手（他工程待ち）",
            "届出情報収集完了（届出可）",
            "届出書作成中",
            "作成済（待機中）",
            "届出中（行政受理待ち）",
            "過去届出分使用",
            "変更届出",
            "案件NG",
            "※過去登録用",
            "食品",
            "ＰＳＥ",
            "雑貨",
            "他社申請"
        ];
    }

    /**
     * List all sampleProgress in airtable
     * 
     * @return array
     */
    public static function sampleProgress()
    {
        return[
            "本輸入から抜く",
            "現物発送依頼済",
            "データ依頼済",
            "写真依頼済",
            "未発送",
            "発送済み",
            "一部のみ到着",
            "商品到着",
            "データ入手",
            "写真入手",
            "商品確認不可",
            "過去確認済み",
            "申請のみ案件"
        ];
    }

    /**
     * List all labelCreationProgress in airtable
     * 
     * @return array
     */
    public static function labelCreationProgress()
    {
        return[
            "作成中",
            "依頼完了",
            "パッケージNG",
            "案件完了",
            "データ校正中（チェックのみ案件）",
            "申請のみ",
            "パッケージＣ中",
            "パッケージＣ済",
            "修正依頼中",
            "※過去登録用",
            "先行作成済み待機中",
            "保留中",
            "食品",
            "PSE",
            "雑貨",
            "お客様作成中",
            "作成可能",
            "お客様作成完了",
            "音信不通",
            "本輸入到着待ち",
            "案件NG"
        ];
    }

    /**
     * List all dataConfirmation in airtable
     * 
     * @return array
     */
    public static function dataConfirmation()
    {
        return[
            "作成中",
            "お客様了承済",
            "修正中",
            "管理部チェック中",
            "案件NG",
            "案件完了",
            "申請のみ",
            "客作成分",
            "※過去登録用",
            "成分チェック中",
            "ーーーーーー",
            "お客様データ確認中"
        ];
    }

    /**
     * List all customerService in airtable
     * 
     * @return array
     */
    public static function customerService()
    {
        return[
            "データ確認依頼中",
            "客ラリー中",
            "客了承",
            "案件NG",
            "申請のみ",
            "※過去登録用"
        ];
    }

    /**
     * List all printingProgress in airtable
     * 
     * @return array
     */
    public static function printingProgress()
    {
        return[
            "印刷系依頼中",
            "ラベル系完了",
            "納期確定（到着待ち）",
            "見積依頼中",
            "案件NG",
            "見積数客確認中",
            "見積内容客確認中",
            "※過去登録用",
            "納品方法未確定",
            "申請のみ"
        ];
    }

    /**
     * List all amazonQuote in airtable
     * 
     * @return array
     */
    public static function amazonQuote()
    {
        return[
            "作成中",
            "完了",
            "サンプル未到着",
            "作業必要",
            "不要"
        ];
    }

    /**
     * List all labelRequester in airtable
     * 
     * @return array
     */
    public static function labelRequester()
    {
        // return all users lists
    }

    /**
     * List all doubleChecker in airtable
     * 
     * @return array
     */
    public static function doubleChecker()
    {
        // return all users
    }

    /**
     * List all labelingPriority in airtable
     * 
     * @return array
     */
    public static function labelingPriority()
    {
        return [
            "最優先",
            "優先",
            "通常"
        ];
    }

    /**
     * List all deliveryCategory in airtable
     * 
     * @return array
     */
    public static function deliveryCategory()
    {
        return [
            "ユニゲ印刷",
            "オンデ印刷",
            "Kfact印刷",
            "データ納品",
            "丸紀印刷",
            "案件NG",
            "未確定（保留）"
        ];
    }
}
