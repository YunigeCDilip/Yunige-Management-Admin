<?php

namespace App\Console\Commands;

use App\Models\Outbound;
use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Delivery;
use App\Models\InterAssistOutbound;
use App\Models\InterAssistOutboundFile;
use App\Models\OutboundAttachment;
use App\Models\Wdata;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MigrateAirtableOutbounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outbound:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable outbound and interassistoutbounds to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate tablename= '.AirtableDatabase::OUTBOUND);
        $clients = new AirtableApiClient(AirtableDatabase::OUTBOUND);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $outbound = Outbound::where('airtable_id', $item['id'])->first();
            if(!$outbound){
                $outbound = new Outbound();
                $outbound->airtable_id = $item['id'];
                $outbound->name = $item['fields']['Name'];
                if(isset($item['fields']['wNumberLink']) && count($item['fields']['wNumberLink']) > 0){
                    $wdata = Wdata::where('airtable_id', $item['fields']['wNumberLink'][0])->first();
                }

                if(isset($item['fields']['運送会社']) && count($item['fields']['運送会社']) > 0){
                    $delivery = Delivery::where('airtable_id', $item['fields']['運送会社'][0])->first();
                }
                $outbound->wdata_id = (isset($item['fields']['wNumberLink']) && $wdata) ? $wdata->id : null;
                $outbound->delivery_id = (isset($item['fields']['運送会社']) && $delivery) ? $delivery->id : null;

                $outbound->warehouse_in_charge = (isset($item['fields']['担当倉庫'])) ? $item['fields']['担当倉庫'] : null;
                $outbound->ship_date = (isset($item['fields']['出荷日']) && !is_array($item['fields']['出荷日'])) ? date('Y-m-d', strtotime($item['fields']['出荷日'])) : null;
                $outbound->create_date = (isset($item['fields']['CreateDate']) && !is_array($item['fields']['CreateDate'])) ? date('Y-m-d', strtotime($item['fields']['CreateDate'])) : null;
                $outbound->estimited_ship_date = (isset($item['fields']['出荷予定日']) && !is_array($item['fields']['出荷予定日'])) ? date('Y-m-d', strtotime($item['fields']['出荷予定日'])) : null;
                $outbound->invoice_no = (isset($item['fields']['送り状番号'])) ? $item['fields']['送り状番号'] : null;
                $outbound->additional_invoice_no = (isset($item['fields']['追加送り状番号'])) ? $item['fields']['追加送り状番号'] : null;
                $outbound->fba_reservation_no = (isset($item['fields']['FBA予約番号'])) ? $item['fields']['FBA予約番号'] : null;
                $outbound->fba_entry_date = (isset($item['fields']['FBA搬入指定入日']) && !is_array($item['fields']['FBA搬入指定入日'])) ? date('Y-m-d', strtotime($item['fields']['FBA搬入指定入日'])) : null;
                $outbound->small_no = (isset($item['fields']['小口数'])) ? $item['fields']['小口数'] : null;
                $outbound->special_notes = (isset($item['fields']['特記事項(最終指示）'])) ? $item['fields']['特記事項(最終指示）'] : null;
                $outbound->fba_no = (isset($item['fields']['FBA番号'])) ? $item['fields']['FBA番号'] : null;
                $outbound->po_no = (isset($item['fields']['PO番号'])) ? $item['fields']['PO番号'] : null;
                $outbound->reserve = (isset($item['fields']['保留'])) ? $item['fields']['保留'] : false;
                $outbound->completed = (isset($item['fields']['完了（担当がメール送信）'])) ? $item['fields']['完了（担当がメール送信）'] : false;
                $outbound->url = (isset($item['fields']['URL1'])) ? $item['fields']['URL1'][0] : null;
                $outbound->next_url = (isset($item['fields']['URL2'])) ? $item['fields']['URL2'][0] : null;
                $outbound->send_email = (isset($item['fields']['メール送信'])) ? $item['fields']['メール送信'] : false;
                $outbound->storehouse = (isset($item['fields']['倉庫'])) ? $item['fields']['倉庫'] : null;
                $outbound->wait_date_create_modify = (isset($item['fields']['WaitDateCreate-modify']) && !is_array($item['fields']['WaitDateCreate-modify'])) ? date('Y-m-d', strtotime($item['fields']['WaitDateCreate-modify'])) : null;
                $outbound->field_33 = (isset($item['fields']['Field 33'])) ? $item['fields']['Field 33'] : null;
                $outbound->field_34 = (isset($item['fields']['Field 34'])) ? $item['fields']['Field 34'] : null;
                $outbound->inter_assist_share = (isset($item['fields']['InterAssist-Share'])) ? $item['fields']['InterAssist-Share'] : null;
                $outbound->url_delivery = (isset($item['fields']['URL-Delivery'])) ? $item['fields']['URL-Delivery'] : null;
                $outbound->mail_text = (isset($item['fields']['Mail Text'])) ? $item['fields']['Mail Text'] : null;
                $outbound->save();

                if(isset($item['fields']['FBAラベル']) && count($item['fields']['FBAラベル']) > 0){
                    foreach($item['fields']['FBAラベル'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'outbound-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new OutboundAttachment();
                        $aFile->outbound_id = $outbound->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->type = 'FBA Reservation Slips';
                        $aFile->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $aFile->ext = isset($value['type']) ? $value['type'] : null;
                        $aFile->save();
                    }
                }

                if(isset($item['fields']['その他']) && count($item['fields']['その他']) > 0){
                    foreach($item['fields']['その他'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'outbound-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new OutboundAttachment();
                        $aFile->outbound_id = $outbound->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->type = 'Others';
                        $aFile->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $aFile->ext = isset($value['type']) ? $value['type'] : null;
                        $aFile->save();
                    }
                }

                if(isset($item['fields']['送り状画像-判取']) && count($item['fields']['送り状画像-判取']) > 0){
                    foreach($item['fields']['送り状画像-判取'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'outbound-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new OutboundAttachment();
                        $aFile->outbound_id = $outbound->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->type = 'InvoiceImageJudgment';
                        $aFile->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $aFile->ext = isset($value['type']) ? $value['type'] : null;
                        $aFile->save();
                    }
                }
            }else{
                $outbound->warehouse_in_charge = (isset($item['fields']['担当倉庫'])) ? $item['fields']['担当倉庫'] : null;
                $outbound->save();
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::OUTBOUND);

        $this->info('Going to migrate tablename= '.AirtableDatabase::INTER_ASSIST_OUTBOUND);
        $clientsA = new AirtableApiClient(AirtableDatabase::INTER_ASSIST_OUTBOUND);
        $airtableA = new AirTable($clientsA);
        $outbounds = $airtableA->all();
        foreach($outbounds as $item){
            $check = InterAssistOutbound::where('airtable_id', $item['id'])->first();
            if(!$check){
                $outbds = new InterAssistOutbound();
                $outbds->airtable_id = $item['id'];
                $outbds->inter_assist_id = $item['fields']['InterAssit- ID'];
                if(isset($item['fields']['出荷リンク']) && count($item['fields']['出荷リンク']) > 0){
                    $obd = Outbound::where('airtable_id', $item['fields']['出荷リンク'][0])->first();
                }
                $outbds->outbound_id = (isset($item['fields']['出荷リンク']) && $obd) ? $obd->id : null;
                $outbds->etd_shipping_date = (isset($item['fields']['出荷予定日'])) ? date('Y-m-d', strtotime($item['fields']['出荷予定日'])) : null;
                $outbds->completion = (isset($item['fields']['完了'])) ? $item['fields']['完了'] : false;
                $outbds->send_email = (isset($item['fields']['メール送信'])) ? $item['fields']['メール送信'] : false;
                $outbds->remarks = (isset($item['fields']['特記事項'])) ? $item['fields']['特記事項'] : null;
                $outbds->fba_id = (isset($item['fields']['FBA ID'])) ? $item['fields']['FBA ID'] : null;
                $outbds->save();

                if(isset($item['fields']['FBA予約票']) && count($item['fields']['FBA予約票']) > 0){
                    foreach($item['fields']['FBA予約票'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'outbound-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new InterAssistOutboundFile();
                        $aFile->inter_assist_outbound_id = $outbds->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->type = 'FBA Reservation Slips';
                        $aFile->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $aFile->ext = isset($value['type']) ? $value['type'] : null;
                        $aFile->save();
                    }
                }
            }
        }

        $this->info('Action complete');
    }
}
