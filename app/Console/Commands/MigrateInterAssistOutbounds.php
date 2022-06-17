<?php

namespace App\Console\Commands;

use App\Models\Outbound;
use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\InterAssistOutbound;
use App\Models\InterAssistOutboundFile;
use Illuminate\Support\Facades\Storage;

class MigrateInterAssistOutbounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interAssistOutbound:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable interAssistOutbound to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate tablename= '.AirtableDatabase::INTER_ASSIST_OUTBOUND);
        $clientsA = new AirtableApiClient(AirtableDatabase::INTER_ASSIST_OUTBOUND);
        $airtableA = new AirTable($clientsA);
        $outbounds = $airtableA->all();
        foreach($outbounds as $item){
            $check = InterAssistOutbound::where('airtable_id', $item['id'])->first();
            if(!$check){
                if(!isset($item['fields']['InterAssit- ID']['error'])){
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
                    \Log::info($outbds);
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
        }

        $this->info('Action complete');
    }
}
