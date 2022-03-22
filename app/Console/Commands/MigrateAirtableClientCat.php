<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\ClientCategory;

class MigrateAirtableClientCat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clientCat:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable clientCat to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate client Categories: tablename= '.AirtableDatabase::CLIENT_CAT);
        $clients = new AirtableApiClient(AirtableDatabase::CLIENT_CAT);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $category){
            $cat = new ClientCategory();
            $cat->airtable_id = $category['id'];
            $cat->name = implode(',', $category['fields']['Name']);
            $cat->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::CLIENT_CAT);

        $this->info('Action complete');
    }
}
