<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Traits\CacheHelperTrait;

class CacheWarehouseData extends Command
{
    use CacheHelperTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:wdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to cache all warehouse data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to cache wdata: tablename= '.AirtableDatabase::WDATA);
        $apiClient = new AirtableApiClient(AirtableDatabase::WDATA);
        $airtable = new AirTable($apiClient);
        $this->forgetCache(AirtableDatabase::WDATA);
        if(!$this->getCache(AirtableDatabase::WDATA)){
            $data = $airtable->all();
            $this->setCache(AirtableDatabase::WDATA, json_encode($data));
        }

        $this->info('Action complete');
    }
}
