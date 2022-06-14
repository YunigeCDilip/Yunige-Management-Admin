<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\FbaList;
use App\Models\FbaOutbound;
use App\Models\Outbound;

class MigrateAirtableFbaList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FbaList:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable FBAList to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate: tablename= '.AirtableDatabase::FBA_LIST);
        $fbaList = new AirtableApiClient(AirtableDatabase::FBA_LIST);
        $airtable = new AirTable($fbaList);
        $data = $airtable->all();
        foreach($data as $fba){
            $FbaList = new FbaList();
            $FbaList->fba_id = $fba['id'];
            $FbaList->fba_name = (isset($fba['fields']['FBA名称'])) ? $fba['fields']['FBA名称'] : null;
            $FbaList->notes = (isset($fba['fields']['Notes'])) ? $fba['fields']['Notes'] : null;
            $FbaList->label = (isset($fba['fields']['Label'])) ? $fba['fields']['Label'] : null;
            $FbaList->address = (isset($fba['fields']['住所'])) ? $fba['fields']['住所'] : null;
            $FbaList->save();
            if($FbaList){
                $outboundList = (isset($fba['fields']['出荷報告'])) ? $fba['fields']['出荷報告'] : null;
                if (!empty($outboundList) && is_array($outboundList)) {
                    foreach ($outboundList as $key => $outbound) {
                        $outbd = Outbound::where('airtable_id', $outbound)->first();
                        if($outbd){
                            $FbaOutbound = new FbaOutbound();
                            $FbaOutbound->fba_id = $FbaList->id;
                            $FbaOutbound->outbound_id = $outbd->id;
                            $FbaOutbound->save();
                        }
                    }
                }
            }
            
            
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::FBA_LIST);

        $this->info('Action complete');

    }
}
