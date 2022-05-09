<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\BrandMaster;
use App\Models\Client;
use App\Models\ClientItem;
use App\Models\Country;
use App\Models\ItemImage;
use App\Models\ItemMaster;

class MigrateAirtableItemMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'itemMaster:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable itemMaster to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate: tablename= '.AirtableDatabase::BRAND_MASTER);
        $brandClients = new AirtableApiClient(AirtableDatabase::BRAND_MASTER);
        $airtableBrand = new AirTable($brandClients);
        $brands = $airtableBrand->all();

        if($brands){
            foreach($brands as $item){
                if(isset($item['fields']['Name']) && $item['fields']['Name'] != ''){
                    $b = new BrandMaster();
                    if(isset($item['fields']['country']) && $item['fields']['country'] != ''){
                        $country = Country::where('name', $item['fields']['country'])->first();
                        if(!$country){
                            $country = new Country();
                            $country->name = $item['fields']['country'];
                            $country->save();
                        }
                    }
                    $b->airtable_id = $item['id'];
                    $b->name = $item['fields']['Name'];
                    $b->country_id = (isset($item['fields']['country'])) ? $country->id : null;
                    $b->en_name = (isset($item['fields']['ブランド名【English】'])) ? $item['fields']['ブランド名【English】'] : null;
                    $b->ja_name = (isset($item['fields']['ブランド名【日本語】'])) ? $item['fields']['ブランド名【日本語】'] : null;
                    $b->parallel_import = (isset($item['fields']['並行輸入'])) ? true : false;
                    $b->brand_logo = (isset($item['fields']['ブランドロゴ'])) ? $item['fields']['ブランドロゴ'][0]['url'] : null;
                    $b->brand_url = (isset($item['fields']['URL'])) ? $item['fields']['URL'] : null;
                    $b->check = (isset($item['fields']['check'])) ? true : false;
                    $b->remarks = (isset($item['fields']['備考'])) ? $item['fields']['備考'] : null;
                    $b->category = (isset($item['fields']['カテゴリ'])) ? $item['fields']['カテゴリ'] : null;
                    $b->save();
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::BRAND_MASTER);

        $this->info('Going to migrate: tablename= '.AirtableDatabase::ITEM_MASTER);
        $clients = new AirtableApiClient(AirtableDatabase::ITEM_MASTER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $itemMaster = new ItemMaster();
            $itemMaster->airtable_id = $item['id'];
            $itemMaster->product_name = $item['fields']['ProductName1'];
            $itemMaster->brand_master_id = (isset($item['fields']['BrandName'])) ? $item['fields']['BrandName'] : null;
            $itemMaster->item_category_id = (isset($item['fields']['Cat'])) ? $item['fields']['Cat'] : null;
            $itemMaster->item_label_id = (isset($item['fields']['LabelStatus'])) ? $item['fields']['LabelStatus'] : null;
            $itemMaster->shipper_id = (isset($item['fields']['Shipper'])) ? $item['fields']['Shipper'] : null;
            $itemMaster->product_barcode = (isset($item['fields']['ProdBarcode'])) ? $item['fields']['ProdBarcode']['text'] : null;
            $itemMaster->description = (isset($item['fields']['ProdDesc'])) ? $item['fields']['ProdDesc'] : null;
            $itemMaster->jp_description = (isset($item['fields']['ProdJpDesc'])) ? $item['fields']['ProdJpDesc'] : null;
            $itemMaster->barcode_entry_date = (isset($item['fields']['BarcodeEntryDate'])) ? $item['fields']['BarcodeEntryDate'] : null;
            $itemMaster->jp_name = (isset($item['fields']['ProdJpName'])) ? $item['fields']['ProdJpName'] : null;
            $itemMaster->productgname = (isset($item['fields']['ProdG_Name'])) ? $item['fields']['ProdG_Name'] : null;
            $itemMaster->gname = (isset($item['fields']['G_Name'])) ? $item['fields']['G_Name'] : null;
            $itemMaster->product_name_1 = (isset($item['fields']['ProdName1'])) ? $item['fields']['ProdName1'] : null;
            $itemMaster->product_name_2 = (isset($item['fields']['ProdName2'])) ? $item['fields']['ProdName2'] : null;
            $itemMaster->availabity = (isset($item['fields']['Availabity'])) ? $item['fields']['Availabity'] : null;
            $itemMaster->unit = (isset($item['fields']['Unit/Set'])) ? $item['fields']['Unit/Set'] : null;
            $itemMaster->weight = (isset($item['fields']['Weight'])) ? $item['fields']['Weight'] : null;
            $itemMaster->weight2 = (isset($item['fields']['Weight2'])) ? $item['fields']['Weight2'] : null;
            $itemMaster->save();

            if($itemMaster){
                if(isset($item['fields']['ProdPhoto'])){
                    foreach($item['fields']['ProdPhoto'] as $photo){
                        $image = new ItemImage();
                        $image->item_master_id = $itemMaster->id;
                        $image->url = $photo['url'];
                        $image->save();
                    }
                }

                if(isset($item['fields']['ClientData'])){
                    foreach($item['fields']['ClientData'] as $client){
                        $c = Client::where('airtable_id', $client)->first();
                        if($c){
                            $ci = new ClientItem();
                            $image->item_master_id = $itemMaster->id;
                            $image->client_id = $c->id;
                            $image->save();
                        }
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::ITEM_MASTER);

        $this->info('Action complete');
    }
}
