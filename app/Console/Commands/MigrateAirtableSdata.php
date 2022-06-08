<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Sdata;
use App\Models\Wdata;
use App\Models\Delivery;
use App\Airtable\AirTable;
use App\Models\ItemMaster;
use App\Models\SdataSample;
use App\Models\AmazonProgress;
use App\Models\SdataAttachment;
use App\Models\SdataItemMaster;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;

class MigrateAirtableSdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdata:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable Sdata to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate sdata: tablename= '.AirtableDatabase::SDATA);
        $clients = new AirtableApiClient(AirtableDatabase::SDATA);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $asdata){
            $sdata = Sdata::where('airtable_id', $asdata['id'])->first();
            if(!$sdata){
                $sdata = new Sdata();
            }
            $sdata->airtable_id = $asdata['id'];
            $sdata->name = $asdata['fields']['案件名'];
            $sdata->serial = isset($asdata['fields']['serial']) ? (($asdata['fields']['serial']['specialValue'] != 'NaN') ? $asdata['fields']['serial']['specialValue'] : null) : null;
            $sdata->case_number = isset($asdata['fields']['案件番号s']) ? $asdata['fields']['案件番号s'] : null;
            $sdata->amazon_sold = isset($asdata['fields']['Amazon販売済']) ? true : false;
            $sdata->by_country = isset($asdata['fields']['国別・区分']) ? $asdata['fields']['国別・区分'][0] : null;
            $sdata->case_in_charge = isset($asdata['fields']['案件担当']) ? $asdata['fields']['案件担当'] : null;
            $sdata->categories = isset($asdata['fields']['商品分類']) ? json_encode($asdata['fields']['商品分類'], true) : null;
            $sdata->memo = isset($asdata['fields']['案件メモ(案件全体の特記事項）']) ? $asdata['fields']['案件メモ(案件全体の特記事項）'] : null;
            $sdata->matter_date = isset($asdata['fields']['案件発生日']) ? date('Y-m-d', strtotime($asdata['fields']['案件発生日'])) : null;
            $sdata->priority = isset($asdata['fields']['優先順位']) ? $asdata['fields']['優先順位'] : null;
            $sdata->priority_change_date = isset($asdata['fields']['優先変更日（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['優先変更日（自動）'])) : null;
            $sdata->ingredient_progress = isset($asdata['fields']['成分進捗']) ? $asdata['fields']['成分進捗'] : null;
            $sdata->ingredient_date = isset($asdata['fields']['成分日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['成分日付（自動）'])) : null;
            $sdata->ingredient_number_ok = isset($asdata['fields']['成分OK数']) ? $asdata['fields']['成分OK数'] : null;
            $sdata->total_ingredient = isset($asdata['fields']['成分チェック数【武田】']) ? $asdata['fields']['成分チェック数【武田】'] : null;
            $sdata->notification_progress = isset($asdata['fields']['届出進捗']) ? $asdata['fields']['届出進捗'][0] : null;
            $sdata->application_date = isset($asdata['fields']['申請日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['申請日付（自動）'])) : null;
            $sdata->foreign_noti = isset($asdata['fields']['外国届出数']) ? $asdata['fields']['外国届出数'] : null;
            $sdata->manufact_sales_noti = isset($asdata['fields']['製販届出数']) ? $asdata['fields']['製販届出数'] : null;
            $sdata->change_noti = isset($asdata['fields']['変更届出数']) ? $asdata['fields']['変更届出数'] : null;
            $sdata->sample_progress = isset($asdata['fields']['サンプル進捗']) ? $asdata['fields']['サンプル進捗'][0] : null;
            $sdata->sample_date = isset($asdata['fields']['サンプル日付']) ? date('Y-m-d', strtotime($asdata['fields']['サンプル日付'])) : null;
            if(isset($asdata['fields']['サンプル配送会社'])){
                $delivery = Delivery::where('airtable_id', $asdata['fields']['サンプル配送会社'][0])->first();
            }
            $sdata->delivery_id = isset($asdata['fields']['サンプル配送会社']) ? $delivery->id : null;
            $sdata->sample_tracking_no = isset($asdata['fields']['サンプル追跡番号']) ? $asdata['fields']['サンプル追跡番号']['text'] : null;
            $sdata->tracking_url = isset($asdata['fields']['追跡URL']) ? $asdata['fields']['追跡URL'] : null;
            $sdata->label_creation_progress = isset($asdata['fields']['ラベル作成進捗']) ? $asdata['fields']['ラベル作成進捗'] : null;
            $sdata->label_creation_date = isset($asdata['fields']['ラベル作成依頼日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['ラベル作成依頼日付（自動）'])) : null;
            $sdata->no_label_design = isset($asdata['fields']['ラベルデザイン数']) ? $asdata['fields']['ラベルデザイン数'] : null;
            $sdata->data_confirmation = isset($asdata['fields']['データ確認進捗（顧客）']) ? $asdata['fields']['データ確認進捗（顧客）'][0] : null;
            $sdata->data_creation_date = isset($asdata['fields']['データ作成日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['データ作成日付（自動）'])) : null;
            $sdata->customer_service = isset($asdata['fields']['顧客対応']) ? $asdata['fields']['顧客対応'] : null;
            $sdata->corresponding_date = isset($asdata['fields']['対応日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['対応日付（自動）'])) : null;
            $sdata->printing_progress = isset($asdata['fields']['データ・印刷進捗']) ? $asdata['fields']['データ・印刷進捗'] : null;
            $sdata->print_date = isset($asdata['fields']['データ印刷日付（自動）']) ? date('Y-m-d', strtotime($asdata['fields']['案件発生日'])) : null;
            $sdata->delivery_category = isset($asdata['fields']['納品区分']) ? $asdata['fields']['納品区分'][0] : null;
            $sdata->label_delivery_date = isset($asdata['fields']['ラベル納品日']) ? date('Y-m-d', strtotime($asdata['fields']['ラベル納品日'])) : null;

            $sdata->ingredient_billing_completed = isset($asdata['fields']['成分請求完了']) ? $asdata['fields']['成分請求完了'] : false;
            $sdata->application_completed = isset($asdata['fields']['申請系請求完了']) ? $asdata['fields']['申請系請求完了'] : false;
            $sdata->label_design_completed = isset($asdata['fields']['ラベルデザイン請求完了']) ? $asdata['fields']['ラベルデザイン請求完了'] : false;

            $sdata->ingredient_billing_date = isset($asdata['fields']['成分請求日']) ? date('Y-m-d', strtotime($asdata['fields']['成分請求日'])) : null;
            $sdata->application_completed_date = isset($asdata['fields']['申請請求日']) ? date('Y-m-d', strtotime($asdata['fields']['申請請求日'])) : null;
            $sdata->label_completed_date = isset($asdata['fields']['ラベル請求完了日']) ? date('Y-m-d', strtotime($asdata['fields']['ラベル請求完了日'])) : null;
            $sdata->analysis_amount = isset($asdata['fields']['分析金額']) ? $asdata['fields']['分析金額'][0] : 0;
            $sdata->other_billed = isset($asdata['fields']['その他請求済み']) ? $asdata['fields']['その他請求済み'] : 0;
            $sdata->other_billed_date = isset($asdata['fields']['その他請求日']) ? date('Y-m-d', strtotime($asdata['fields']['その他請求日'])) : null;

            $sdata->all_completed_billing = isset($asdata['fields']['全てのs（成分届出ラベルその他）請求完了']) ? $asdata['fields']['全てのs（成分届出ラベルその他）請求完了'] : false;
            $sdata->all_completed_date = isset($asdata['fields']['すべて完了日【自動】']) ? date('Y-m-d', strtotime($asdata['fields']['すべて完了日【自動】'])) : null;
            if(isset($asdata['fields']['AmazonProgress'])){
                $amazon = AmazonProgress::where('airtable_id', $asdata['fields']['AmazonProgress'][0])->first();
            }
            $sdata->amazon_progress_id = isset($asdata['fields']['AmazonProgress']) ? $amazon->id : null;
            // $sdata->aggregation_month = isset($asdata['fields']['月(集計用)']) ? $asdata['fields']['月(集計用)'] : null;
            $sdata->created_serial_no = isset($asdata['fields']['連番作成用（※非表示）']) ? $asdata['fields']['連番作成用（※非表示）'] : null;
            $sdata->revised_label = isset($asdata['fields']['改定ラベル（1000円）']) ? $asdata['fields']['改定ラベル（1000円）'] : null;
            $sdata->billing_competed_kurohara = isset($asdata['fields']['請求完了(※黒原専用）']) ? $asdata['fields']['請求完了(※黒原専用）'] : false;
            
            $sdata->amazon_quote = isset($asdata['fields']['amazon見積作成']) ? $asdata['fields']['amazon見積作成'] : null;
            $sdata->declatation_number = isset($asdata['fields']['申告番号']) ? $asdata['fields']['申告番号'] : null;
            $sdata->product_master = isset($asdata['fields']['商品マスター']) ? $asdata['fields']['商品マスター'] : null;
            
            $sdata->label_requester = isset($asdata['fields']['ラベル依頼者']) ? $asdata['fields']['ラベル依頼者'] : null;
            $sdata->double_checker = isset($asdata['fields']['ダブルチェック者']) ? $asdata['fields']['ダブルチェック者'] : null;

            $sdata->double_checked = isset($asdata['fields']['ダブルチェック済']) ? $asdata['fields']['ダブルチェック済'] : false;
            $sdata->ingredient_costs = isset($asdata['fields']['成分費（自動×3000円）']) ? $asdata['fields']['成分費（自動×3000円）'] : null;
            $sdata->foreign_noti_fee = isset($asdata['fields']['外国届費（自動×3000）']) ? $asdata['fields']['外国届費（自動×3000）'] : null;
            $sdata->manufact_sales_noti_fee = isset($asdata['fields']['製販届費（自動×1500円）']) ? $asdata['fields']['製販届費（自動×1500円）'] : null;
            $sdata->change_noti_fee = isset($asdata['fields']['変更届自動（自動×1500円']) ? $asdata['fields']['変更届自動（自動×1500円'] : null;
            $sdata->label_design_fee = isset($asdata['fields']['ラベルデザイン費（自動×3000円）']) ? $asdata['fields']['ラベルデザイン費（自動×3000円）'] : null;
            $sdata->print_components = isset($asdata['fields']['印刷成分（2020.3.26以前）']) ? $asdata['fields']['印刷成分（2020.3.26以前）'] : false;
            $sdata->stamp_print_murata = isset($asdata['fields']['ハンコ版印刷成分（2020.3.26以降）村田品質']) ? $asdata['fields']['ハンコ版印刷成分（2020.3.26以降）村田品質'] : false;
            $sdata->stamp_print_sugio = isset($asdata['fields']['ハンコ版印刷成分（2020.5.26以降）杉生品質']) ? $asdata['fields']['ハンコ版印刷成分（2020.5.26以降）杉生品質'] : false;
            $sdata->labeling_priority = isset($asdata['fields']['ラベル作成優先順位']) ? $asdata['fields']['ラベル作成優先順位'] : null;
            $sdata->calculation = isset($asdata['fields']['Calculation']) ? $asdata['fields']['Calculation'] : null;
            $sdata->ingredient_request_takeda = isset($asdata['fields']['武田さんへ成分依頼']) ? $asdata['fields']['武田さんへ成分依頼'] : null;
            $sdata->product_master_request = isset($asdata['fields']['商品マスタ依頼用']) ? $asdata['fields']['商品マスタ依頼用'] : null;
            $sdata->count_product_masters = isset($asdata['fields']['商品マスター数（カウント）']) ? $asdata['fields']['商品マスター数（カウント）'] : null;
            $sdata->ingredient_special_note = isset($asdata['fields']['成分依頼特記事項']) ? $asdata['fields']['成分依頼特記事項'] : null;
            $sdata->ingredient_transmission = isset($asdata['fields']['成分依頼メール送信【KOREA】']) ? $asdata['fields']['成分依頼メール送信【KOREA】'] : false;
            if(isset($asdata['fields']['案件担当名'])){
                $user = User::where('airtable_id', $asdata['fields']['案件担当名'][0])->first();
            }
            $sdata->user_id = isset($asdata['fields']['案件担当名']) ? $user->id : null;
            $sdata->transmission_international = isset($asdata['fields']['成分依頼メール送信【国際部】']) ? $asdata['fields']['成分依頼メール送信【国際部】'] : false;
            $sdata->transmission_national = isset($asdata['fields']['成分依頼メール送信【JAPAN】']) ? $asdata['fields']['成分依頼メール送信【JAPAN】'] : false;
            $sdata->takeda_email = isset($asdata['fields']['武田さん成分回答メール']) ? $asdata['fields']['武田さん成分回答メール'] : null;
            $sdata->kanban_printed = isset($asdata['fields']['カンバン印刷済み']) ? $asdata['fields']['カンバン印刷済み'] : false;
            $sdata->storage_link = isset($asdata['fields']['データ格納リンク']) ? $asdata['fields']['データ格納リンク'] : null;
            $sdata->test_link = isset($asdata['fields']['共有テストリンク']) ? $asdata['fields']['共有テストリンク'] : null;
            if(isset($asdata['fields']['ラベル依頼者NEO'])){
                $requester = User::where('airtable_id', $asdata['fields']['ラベル依頼者NEO'][0])->first();
            }
            $sdata->label_requester_id = (isset($asdata['fields']['ラベル依頼者NEO']) && $requester) ? $requester->id : null;
            $sdata->supplementary_memo = isset($asdata['fields']['ラベル作成依頼全体補足メモ']) ? $asdata['fields']['ラベル作成依頼全体補足メモ'] : null;
            $sdata->send_label_creation = isset($asdata['fields']['ラベル作成依頼メール送信']) ? $asdata['fields']['ラベル作成依頼メール送信'] : false;
            $sdata->label_creation_request = isset($asdata['fields']['ラベル作成依頼日付']) ? $asdata['fields']['ラベル作成依頼日付'] : null; //date
            $sdata->email = isset($asdata['fields']['メールアドレス (from ラベル依頼者NEO)']) ? $asdata['fields']['メールアドレス (from ラベル依頼者NEO)'][0] : null;
            $sdata->save();

            if($sdata){

                if(isset($asdata['fields']['送り状'])){
                    foreach($asdata['fields']['送り状'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'Invoice';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($asdata['fields']['インボイス'])){
                    foreach($asdata['fields']['インボイス'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'Invoice';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
                if(isset($asdata['fields']['確定成分表'])){
                    foreach($asdata['fields']['確定成分表'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'IngredientList';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
                if(isset($asdata['fields']['ラベルデータ最新'])){
                    foreach($asdata['fields']['ラベルデータ最新'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'LabelData';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
                if(isset($asdata['fields']['成分チェック依頼データ格納'])){
                    foreach($asdata['fields']['成分チェック依頼データ格納'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'ComponentCheck';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
                if(isset($asdata['fields']['s-QR'])){
                    foreach($asdata['fields']['s-QR'] as $value){
                        $file = new SdataAttachment();
                        $file->sdata_id = $sdata->id;
                        $file->type = 'QRCode';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
                if(isset($asdata['fields']['アイテム【商品マスターリンク】'])){
                    foreach($asdata['fields']['アイテム【商品マスターリンク】'] as $value){
                        $im = ItemMaster::where('airtable_id', $value)->first();
                        if($im){
                            $new = new SdataItemMaster();
                            $new->sdata_id = $sdata->id;
                            $new->item_master_id = $im->id;
                            $new->save();
                        }
                    }
                }
                if(isset($asdata['fields']['wサンプル'])){
                    foreach($asdata['fields']['wサンプル'] as $value){
                        $im = Wdata::where('airtable_id', $value)->first();
                        if($im){
                            $new = new SdataSample();
                            $new->sdata_id = $sdata->id;
                            $new->wdata_id = $im->id;
                            $new->save();
                        }
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::SDATA);

        $this->info('Action complete');
    }
}
