<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Traits\CacheHelperTrait;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;

class CacheMasterItems extends Command
{
    use CacheHelperTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:master';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands used to cache master items for wdata';

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
        $this->info('Going to cache clients: tablename= '.AirtableDatabase::CLIENT_MASTER);
        $this->forgetCache(AirtableDatabase::CLIENT_MASTER);
        $clients = new AirtableApiClient(AirtableDatabase::CLIENT_MASTER);
        $this->cacheMaster($clients, AirtableDatabase::CLIENT_MASTER);
        $this->info('Action complete for: tablename= '.AirtableDatabase::CLIENT_MASTER);

        $this->info('Going to cache clients: tablename= '.AirtableDatabase::DELIVERY);
        $this->forgetCache(AirtableDatabase::DELIVERY);
        $carriers = new AirtableApiClient(AirtableDatabase::DELIVERY);
        $this->cacheMaster($carriers, AirtableDatabase::DELIVERY);
        $this->info('Action complete for: tablename= '.AirtableDatabase::DELIVERY);

        $this->info('Action complete');
    }

    /**
     * @param AirtableApiClient $apiClient
     * @param $table
     * 
     * @return [type]
     */
    private function cacheMaster(AirtableApiClient $apiClient, $table)
    {
        $airtable = new AirTable($apiClient);
        if(!$this->getCache($table)){
            $data = $airtable->all();
            $this->setCache($table, $data);
        }
    }
}
