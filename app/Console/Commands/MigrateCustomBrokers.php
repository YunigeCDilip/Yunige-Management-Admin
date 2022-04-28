<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use App\Models\ClientCategory;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\CustomBroker;
use App\Models\Wdata;
use App\Models\WdataCustomBroker;

class MigrateCustomBrokers extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customBrokers:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable customBrokers to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate client Categories: tablename= '.AirtableDatabase::CUSTOM_BROKER);
        $clients = new AirtableApiClient(AirtableDatabase::CUSTOM_BROKER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $broker = CustomBroker::where('airtable_id', $item['id'])->first();
            if(!$broker){
                $broker = new CustomBroker();
            }
            $broker->airtable_id = $item['id'];
            $broker->name = (isset($item['fields']['Name'])) ? $item['fields']['Name'] : null;
            $broker->email = (isset($item['fields']['メール'])) ? $item['fields']['メール'] : null;
            $broker->telephone_no = (isset($item['fields']['電話番号'])) ? $item['fields']['電話番号'] : null;
            $broker->fax_number = (isset($item['fields']['FAX番号'])) ? $item['fields']['FAX番号'] : null;
            $broker->url = (isset($item['fields']['URL'])) ? $item['fields']['URL'] : null;
            $broker->url_back = (isset($item['fields']['URL-back'])) ? $item['fields']['URL-back'] : null;
            $broker->data_by_matter = (isset($item['fields']['案件別データ'])) ? $item['fields']['案件別データ'] : null;
            $broker->store_house = (isset($item['fields']['倉庫'])) ? $item['fields']['倉庫'] : null;
            $broker->test = (isset($item['fields']['TEST'])) ? $item['fields']['TEST'] : null;
            $broker->product_master = (isset($item['fields']['商品マスター'])) ? $item['fields']['商品マスター'] : null;
            $broker->table_70 = (isset($item['fields']['Table 17'])) ? $item['fields']['Table 17'] : null;
            $broker->warehouse_2 = (isset($item['fields']['倉庫 2'])) ? $item['fields']['倉庫 2'] : null;
            $broker->address = (isset($item['fields']['住所'])) ? $item['fields']['住所'] : null;
            $broker->request_otsunaka = (isset($item['fields']['依頼乙仲'])) ? $item['fields']['依頼乙仲'] : null;
            $broker->save();
            if(isset($item['fields']['倉庫 3'])){
                WdataCustomBroker::where('custom_broker_id', $broker->id)->delete();
                foreach($item['fields']['倉庫 3'] as $index => $wdata){
                    $dd = Wdata::where('airtable_id', $wdata)->first();
                    if($dd){
                        $wcb = new WdataCustomBroker();
                        $wcb->wdata_id = $dd->id;
                        $wcb->custom_broker_id = $broker->id;
                        $wcb->save();
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::CUSTOM_BROKER);

        $this->info('Action complete');
    }
}
