<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use App\Models\AmazonProgress;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;

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
            $amazon = new AmazonProgress();
            $amazon->airtable_id = $item['id'];
            $amazon->name = $item['fields']['Name'];
            $amazon->save();
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::AMAZON_PROGRESS);

        $this->info('Action complete');
    }
}
