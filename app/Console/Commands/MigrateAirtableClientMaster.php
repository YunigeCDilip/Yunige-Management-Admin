<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\ClientContact;
use App\Models\ClientItem;
use App\Models\ClientSdata;
use App\Models\ClientWdata;
use App\Models\ForeignDeliveryClassification;
use App\Models\ItemMaster;
use App\Models\MovementConfirmation;
use App\Models\Sdata;
use App\Models\Shipper;
use App\Models\Wdata;

class MigrateAirtableClientMaster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clientMaster:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Aritable clientMaster to this service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Going to migrate: tablename= '.AirtableDatabase::CLIENT_MASTER);
        $clients = new AirtableApiClient(AirtableDatabase::CLIENT_MASTER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $clientMaster = new Client();
            $clientMaster->airtable_id = $item['id'];
            $clientMaster->client_name = (isset($item['fields']['ClientName'])) ? $item['fields']['ClientName'] : null;
            $clientNumber = explode('c', $item['fields']['ClientNo']);
            $clientMaster->serial_number = $clientNumber[1];
            $clientMaster->ja_name = (isset($item['fields']['ClientJP'])) ? $item['fields']['ClientJP'] : null;
            $clientMaster->en_name = (isset($item['fields']['ClientEng'])) ? $item['fields']['ClientEng'] : null;
            if(isset($item['fields']['Shipper/Forwarder']) && $item['fields']['Shipper/Forwarder']){
                $shipper = Shipper::where('shipper_name', $item['fields']['Shipper/Forwarder'])->first();
                $clientMaster->shipper_id = ($shipper) ? $shipper->id : null;
            }
            $clientMaster->hp = (isset($item['fields']['HP'])) ? $item['fields']['HP'] : null;
            $clientMaster->request = (isset($item['fields']['請求（案件別）'])) ? $item['fields']['請求（案件別）'] : null;
            $clientMaster->foreign_dropbox_link = (isset($item['fields']['外国届'])) ? $item['fields']['外国届'] : null;
            $clientMaster->foreign_noti = (isset($item['fields']['外国届検索用羅列・杉生'])) ? $item['fields']['外国届検索用羅列・杉生'] : null;
            $clientMaster->warehouse_remarks = (isset($item['fields']['WarehouseRemark'])) ? $item['fields']['WarehouseRemark'] : null;
            $clientMaster->customer_classification = (isset($item['fields']['顧客分類'])) ? $item['fields']['顧客分類'] : null;
            $clientMaster->invoice = (isset($item['fields']['Invoice'])) ? $item['fields']['Invoice'] : null;
            $clientMaster->company_tel = (isset($item['fields']['CompanyTel'])) ? $item['fields']['CompanyTel'] : null;
            $clientMaster->fax = (isset($item['fields']['FAX'])) ? $item['fields']['FAX'] : null;
            $clientMaster->warehouse_mgnt_copy = (isset($item['fields']['奉行　入庫管理'])) ? $item['fields']['奉行　入庫管理 copy'] : null;
            if(isset($item['fields']['★移動確認']) && $item['fields']['★移動確認']){
                $movement = MovementConfirmation::where('name', $item['fields']['★移動確認'])->first();
                $clientMaster->movement_confirmation_id = ($movement) ? $movement->id : null;
            }
            $clientMaster->work_management = (isset($item['fields']['奉行　作業管理'])) ? $item['fields']['奉行　作業管理'] : null;
            $clientMaster->table_30 = (isset($item['fields']['Table_30'])) ? $item['fields']['Table_30'] : null;
            $clientMaster->email_2 = (isset($item['fields']['メール2'])) ? $item['fields']['メール2'] : null;
            $clientMaster->sugio_book_print = (isset($item['fields']['標準書印刷済み杉生'])) ? $item['fields']['標準書印刷済み杉生'] : false;
            $clientMaster->yamazaki_book_print = (isset($item['fields']['標準書印刷済み山崎'])) ? $item['fields']['標準書印刷済み山崎'] : false;
            $clientMaster->on_dropbox = (isset($item['fields']['OnDropbox_NotAirtable'])) ? $item['fields']['OnDropbox_NotAirtable'] : false;
            $clientMaster->on_airtable = (isset($item['fields']['OnAirtable_NotDropbox'])) ? $item['fields']['OnAirtable_NotDropbox'] : false;
            if(isset($item['fields']['外国届け分類']) && $item['fields']['外国届け分類']){
                $classification = ForeignDeliveryClassification::where('name', $item['fields']['外国届け分類'])->first();
                $clientMaster->foreign_delivery_classifications_id = ($classification) ? $classification->id : null;
            }
            $clientMaster->takatsu_working_date = (isset($item['fields']['高津さん作業日'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['高津さん作業日'])) : null;
            $clientMaster->product_master = (isset($item['fields']['ProdMasterData2'])) ? $item['fields']['ProdMasterData2'] : null;
            $clientMaster->field_61 = (isset($item['fields']['Field_61'])) ? $item['fields']['Field_61'] : null;
            $clientMaster->save();

            if($clientMaster){
                $contact = new ClientContact();
                $contact->client_id = $clientMaster->id;
                $contact->name = (isset($item['fields']['RespPer'])) ? $item['fields']['RespPer'] : null;
                $contact->office_add = (isset($item['fields']['OfficeAdd'])) ? $item['fields']['OfficeAdd'] : null;
                $contact->email = (isset($item['fields']['E-mail'])) ? $item['fields']['E-mail'] : null;
                $contact->contact_number = (isset($item['fields']['ContactNo'])) ? $item['fields']['ContactNo'] : null;
                $contact->seller_name = (isset($item['fields']['ContactNo'])) ? $item['fields']['ContactNo'] : null;
                $contact->pic_add = (isset($item['fields']['PickAdd'])) ? $item['fields']['PickAdd'] : null;
                $contact->save();

                $this->saveCategory($clientMaster, $item);
                $this->saveRequestedClient($clientMaster, $item);
                $this->saveSdata($clientMaster, $item);
                $this->saveWarehouseData($clientMaster, $item);
                $this->saveMasterData($clientMaster, $item);
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::CLIENT_MASTER);

        $this->info('Action complete');
    }

    /**
     * @param Client $client
     * @param mixed $item
     * 
     * @return [type]
     */
    private function saveCategory(Client $client, $item)
    {
        if(isset($item['fields']['Docs']) && count($item['fields']['Docs']) > 0){
            $cat = ClientCategory::where('airtable_id', $item['fields']['Docs'][0])->first();
            $client->client_category_id = ($cat) ? $cat->id : null;
            $client->save();
        }
    }

    /**
     * @param Client $client
     * @param mixed $item
     * 
     * @return [type]
     */
    private function saveRequestedClient(Client $client, $item)
    {
        if(isset($item['fields']['依頼顧客紐付け']) && count($item['fields']['依頼顧客紐付け']) > 0){
            $cat = Client::where('airtable_id', $item['fields']['依頼顧客紐付け'][0])->first();
            $client->request_client_id = ($cat) ? $cat->id : null;
            $client->save();
        }
    }

    /**
     * @param Client $client
     * @param mixed $item
     * 
     * @return [type]
     */
    private function saveSdata(Client $client, $item)
    {
        if(isset($item['fields']['ClientData']) && count($item['fields']['ClientData']) > 0){
            $sdatas = Sdata::whereIn('airtable_id', $item['fields']['ClientData'])->get();
            if($sdatas){
                foreach($sdatas as $d)
                {
                    $cd = new ClientSdata();
                    $cd->client_id = $client->id;
                    $cd->sdata_id = $d->id;
                    $cd->save();
                }
            }
        }
    }

    /**
     * @param Client $client
     * @param mixed $item
     * 
     * @return [type]
     */
    private function saveWarehouseData(Client $client, $item)
    {
        if(isset($item['fields']['WarehouseData']) && count($item['fields']['WarehouseData']) > 0){
            $sdatas = Wdata::whereIn('airtable_id', $item['fields']['WarehouseData'])->get();
            if($sdatas){
                foreach($sdatas as $d)
                {
                    $cd = new ClientWdata();
                    $cd->client_id = $client->id;
                    $cd->wdata_id = $d->id;
                    $cd->save();
                }
            }
        }
    }

    /**
     * @param Client $client
     * @param mixed $item
     * 
     * @return [type]
     */
    private function saveMasterData(Client $client, $item)
    {
        if(isset($item['fields']['MasterData']) && count($item['fields']['MasterData']) > 0){
            $sdatas = ItemMaster::whereIn('airtable_id', $item['fields']['MasterData'])->get();
            if($sdatas){
                foreach($sdatas as $d)
                {
                    $cd = new ClientItem();
                    $cd->client_id = $client->id;
                    $cd->item_master_id = $d->id;
                    $cd->save();
                }
            }
        }
    }
}
