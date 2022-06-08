<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Delivery;

class MigrateAirtableDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable delivery to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate tablename= '.AirtableDatabase::DELIVERY);
        $clients = new AirtableApiClient(AirtableDatabase::DELIVERY);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $delivery = Delivery::where('airtable_id', $item['id'])->first();
            if(!$delivery){
                $delivery = new Delivery();
            }
            $delivery->airtable_id = $item['id'];
            $delivery->name = $item['fields']['Name'];
            $delivery->url = (isset($item['fields']['URL'])) ? $item['fields']['URL'] : null;
            $delivery->url_back = (isset($item['fields']['URL-back'])) ? $item['fields']['URL-back'] : null;
            $delivery->store_house = (isset($item['fields']['storehouse'])) ? $item['fields']['storehouse'] : null;
            $delivery->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::DELIVERY);

        $this->info('Action complete');
    }
}
