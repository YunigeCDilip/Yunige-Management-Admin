<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Designation;
use App\Models\User;
use App\Models\UserDesignation;

class MigrateAirtableMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable member to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate tablename= ' . AirtableDatabase::MEMBER);
        $clients = new AirtableApiClient(AirtableDatabase::MEMBER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach ($data as $item) {
            if((isset($item['fields']['メールアドレス'])) && $item['fields']['メールアドレス'] != ''){
                $member = User::where('airtable_id', $item['id'])->first();
                if (!$member) {
                    $member = new User();
                }
                $member->airtable_id = $item['id'];
                $member->name = $item['fields']['Name'];
                $member->active_status = true;
                $member->is_super_admin = false;
                $member->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
                $member->email = (isset($item['fields']['メールアドレス'])) ? $item['fields']['メールアドレス'] : null;
                $member->save();

                if(isset($item['fields']['カテゴリ'])){
                    UserDesignation::where('user_id', $member->id)->delete();
                    foreach($item['fields']['カテゴリ'] as $value){
                        $designation = Designation::where('name', $value)->first();
                        if($designation){
                            $ud = new UserDesignation();
                            $ud->user_id = $member->id;
                            $ud->designation_id = $designation->id;
                            $ud->save();
                        }
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= ' . AirtableDatabase::MEMBER);

        $this->info('Action complete');
    }
}
