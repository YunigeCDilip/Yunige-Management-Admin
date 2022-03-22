<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Sdata;

class MigrateAirtableSdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdata:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable Sdata to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate sdata: tablename= '.AirtableDatabase::SDATA);
        $clients = new AirtableApiClient(AirtableDatabase::SDATA);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $asdata){
            $sdata = new Sdata();
            $sdata->airtable_id = $asdata['id'];
            $sdata->name = $asdata['fields']['案件名'];
            $sdata->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::SDATA);

        $this->info('Action complete');
    }
}
