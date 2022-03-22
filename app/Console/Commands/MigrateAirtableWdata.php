<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Wdata;

class MigrateAirtableWdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wdata:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable wdata to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate Wdata: tablename= '.AirtableDatabase::WDATA);
        $clients = new AirtableApiClient(AirtableDatabase::WDATA);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $wdata = new Wdata();
            $wdata->airtable_id = $item['id'];
            $wdata->name = $item['fields']['Name'];
            $wdata->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::WDATA);

        $this->info('Action complete');
    }
}
