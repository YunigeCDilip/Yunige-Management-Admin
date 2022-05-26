<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Airtable\AirTable;
use App\Models\BrandMaster;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;

class MigrateBrandMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brandMaster:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable BrandMaster to this service';

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
    }
}
