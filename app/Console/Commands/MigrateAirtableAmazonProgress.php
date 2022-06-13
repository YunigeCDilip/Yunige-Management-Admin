<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Airtable\AirTable;
use App\Models\AmazonProgress;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\ClientAmazonProgress;
use Illuminate\Support\Facades\Storage;
use App\Models\AmazonProgressFile;

class MigrateAirtableAmazonProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable amazon progress to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate tablename= '.AirtableDatabase::AMAZON_PROGRESS);
        $clients = new AirtableApiClient(AirtableDatabase::AMAZON_PROGRESS);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $check = AmazonProgress::where('airtable_id', $item['id'])->first();
            if(!$check){
                $amazon = new AmazonProgress();
                $amazon->airtable_id = $item['id'];
                $amazon->name = $item['fields']['Name'];
                $amazon->status = (isset($item['fields']['Status'])) ? $item['fields']['Status'] : null;
                $amazon->pickup = (isset($item['fields']['Pickup'])) ? $item['fields']['Pickup'] : null;
                $amazon->memo = (isset($item['fields']['Memo'])) ? $item['fields']['Memo'] : null;
                $amazon->done = (isset($item['fields']['Done'])) ? $item['fields']['Done'] : false;
                $amazon->save();
    
                if($amazon && isset($item['fields']['Customer Name'][0])){
                    $client = Client::where('airtable_id', $item['fields']['Customer Name'][0])->first();
                    if($client){
                        $ac = new ClientAmazonProgress();
                        $ac->client_id = $client->id;
                        $ac->amazon_progress_id = $amazon->id;
                        $ac->save();
                    }
                }

                if(isset($item['fields']['File']) && count($item['fields']['File']) > 0){
                    foreach($item['fields']['File'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new AmazonProgressFile();
                        $aFile->amazon_progress_id = $amazon->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->save();
                    }
                }
            }else{
                if(isset($item['fields']['File']) && count($item['fields']['File']) > 0){
                    foreach($item['fields']['File'] as $file){
                        $contents = file_get_contents($file['url']);
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file['filename']);
                        Storage::disk('s3')->put($fileName, $contents);
                        $aFile = new AmazonProgressFile();
                        $aFile->amazon_progress_id = $check->id;
                        $aFile->url = Storage::disk('s3')->url($fileName);
                        $aFile->save();
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::AMAZON_PROGRESS);

        $this->info('Action complete');
    }
}
