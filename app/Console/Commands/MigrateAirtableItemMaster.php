<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
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
        $this->info('Going to migrate: tablename= '.AirtableDatabase::ITEM_MASTER);
        $clients = new AirtableApiClient(AirtableDatabase::ITEM_MASTER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $itemMaster = new ItemMaster();
            $itemMaster->airtable_id = $item['id'];
            $itemMaster->product_name = $item['fields']['ProductName1'];
            $itemMaster->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::ITEM_MASTER);

        $this->info('Action complete');
    }
}
