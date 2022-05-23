<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\BrandMaster;
use App\Models\Client;
use App\Models\ClientItem;
use App\Models\Country;
use App\Models\ItemCategory;
use App\Models\ItemImage;
use App\Models\ItemLabel;
use App\Models\ItemMaster;
use App\Models\ItemMasterProductType;
use App\Models\PdfItemLabel;
use App\Models\ProductType;
use App\Models\Shipper;

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
        $this->info('Going to migrate: tablename= '.AirtableDatabase::BRAND_MASTER);
        $brandClients = new AirtableApiClient(AirtableDatabase::BRAND_MASTER);
        $airtableBrand = new AirTable($brandClients);
        $brands = $airtableBrand->all();

        if($brands){
            foreach($brands as $item){
                if(isset($item['fields']['Name']) && $item['fields']['Name'] != ''){
                    $b = new BrandMaster();
                    if(isset($item['fields']['country']) && $item['fields']['country'] != ''){
                        $country = Country::where('name', $item['fields']['country'])->first();
                        if(!$country){
                            $country = new Country();
                            $country->name = $item['fields']['country'];
                            $country->save();
                        }
                    }
                    $b->airtable_id = $item['id'];
                    $b->name = $item['fields']['Name'];
                    $b->country_id = (isset($item['fields']['country'])) ? $country->id : null;
                    $b->en_name = (isset($item['fields']['ブランド名【English】'])) ? $item['fields']['ブランド名【English】'] : null;
                    $b->ja_name = (isset($item['fields']['ブランド名【日本語】'])) ? $item['fields']['ブランド名【日本語】'] : null;
                    $b->parallel_import = (isset($item['fields']['並行輸入'])) ? true : false;
                    $b->brand_logo = (isset($item['fields']['ブランドロゴ'])) ? $item['fields']['ブランドロゴ'][0]['url'] : null;
                    $b->brand_url = (isset($item['fields']['URL'])) ? $item['fields']['URL'] : null;
                    $b->check = (isset($item['fields']['check'])) ? true : false;
                    $b->remarks = (isset($item['fields']['備考'])) ? $item['fields']['備考'] : null;
                    $b->category = (isset($item['fields']['カテゴリ'])) ? $item['fields']['カテゴリ'] : null;
                    $b->save();
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::BRAND_MASTER);

        $this->info('Going to migrate: tablename= '.AirtableDatabase::ITEM_MASTER);
        $clients = new AirtableApiClient(AirtableDatabase::ITEM_MASTER);
        $airtable = new AirTable($clients);
        $data = $airtable->all();
        foreach($data as $item){
            $itemMaster = ItemMaster::where('airtable_id', $item['id'])->first();
            if(!$itemMaster){
                if(isset($item['fields']['BrandName'])){
                    $brandData = BrandMaster::where('airtable_id', $item['fields']['BrandName'][0])->first();
                }
                if(isset($item['fields']['Cat'])){
                    $cat = ItemCategory::where('name', $item['fields']['Cat'])->first();
                }
                if(isset($item['fields']['LabelStatus'])){
                    $label = ItemLabel::where('name', $item['fields']['LabelStatus'][0])->first();
                    if(!$label){
                        $label = new ItemLabel();
                        $label->name = $item['fields']['LabelStatus'][0];
                        $label->save();
                    }
                }
                if(isset($item['fields']['Shipper']) && $item['fields']['Shipper'] != ''){
                    $shipper = Shipper::where('shipper_name', $item['fields']['Shipper'][0])->first();
                    if(!$shipper){
                        $shipper = new ItemLabel();
                        $shipper->shipper_name = $item['fields']['Shipper'][0];
                        $shipper->save();
                    }
                }
                $itemMaster = new ItemMaster();
                $itemMaster->airtable_id = $item['id'];
                $itemMaster->product_name = $item['fields']['ProductName1'];
                $itemMaster->brand_master_id = (isset($item['fields']['BrandName'])) ? $brandData->id : null;
                $itemMaster->item_category_id = (isset($item['fields']['Cat'])) ? $cat->id : null;
                $itemMaster->item_label_id = (isset($item['fields']['LabelStatus'])) ? $label->id : null;
                $itemMaster->shipper_id = (isset($item['fields']['Shipper']) && $item['fields']['Shipper'] != '') ? $shipper->id : null;
                $itemMaster->product_barcode = (isset($item['fields']['ProdBarcode'])) ? $item['fields']['ProdBarcode']['text'] : null;
                $itemMaster->description = (isset($item['fields']['ProdDesc'])) ? $item['fields']['ProdDesc'] : null;
                $itemMaster->jp_description = (isset($item['fields']['ProdJpDesc'])) ? $item['fields']['ProdJpDesc'] : null;
                $itemMaster->barcode_entry_date = (isset($item['fields']['BarcodeEntryDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['BarcodeEntryDate'])) : null;
                $itemMaster->jp_name = (isset($item['fields']['ProdJpName'])) ? $item['fields']['ProdJpName'] : null;
                $itemMaster->productgname = (isset($item['fields']['ProdG_Name'])) ? $item['fields']['ProdG_Name'] : null;
                $itemMaster->gname = (isset($item['fields']['G_Name'])) ? $item['fields']['G_Name'] : null;
                $itemMaster->product_name_1 = (isset($item['fields']['ProdName1'])) ? $item['fields']['ProdName1'] : null;
                $itemMaster->product_name_2 = (isset($item['fields']['ProdName2'])) ? $item['fields']['ProdName2'] : null;
                $itemMaster->availabity = (isset($item['fields']['Availabity'])) ? $item['fields']['Availabity'] : null;
                $itemMaster->unit = (isset($item['fields']['Unit/Set'])) ? $item['fields']['Unit/Set'] : null;
                $itemMaster->weight = (isset($item['fields']['Weight'])) ? $item['fields']['Weight'] : null;
                $itemMaster->weight2 = (isset($item['fields']['Weight2'])) ? $item['fields']['Weight2'] : null;

                $itemMaster->label_link = (isset($item['fields']['Label(Link)'])) ? $item['fields']['Label(Link)'] : null; // file
                $itemMaster->label_pdf_date = (isset($item['fields']['LabelPDF_Date'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LabelPDF_Date'])) : null;
                $itemMaster->stricted_words = (isset($item['fields']['RestrictedWords1'])) ? $item['fields']['RestrictedWords1'] : null;
                $itemMaster->w_no = (isset($item['fields']['w/No'])) ? $item['fields']['w/No'] : null;
                $itemMaster->ing_list = (isset($item['fields']['IngList'])) ? $item['fields']['IngList'] : null;
                $itemMaster->label_date = (isset($item['fields']['LabelDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LabelDate'])) : null;
                $itemMaster->rec_mark = (isset($item['fields']['RECMark'])) ? json_encode($item['fields']['RECMark']) : null; //array
                $itemMaster->sampling = (isset($item['fields']['Sampling'])) ? $item['fields']['Sampling'] : null;
                $itemMaster->lot_sampling = (isset($item['fields']['LotSampling'])) ? $item['fields']['LotSampling'] : null;
                $itemMaster->product_nickname = (isset($item['fields']['愛称'])) ? $item['fields']['愛称'] : null;
                $itemMaster->outer_height = (isset($item['fields']['OuterWidth'])) ? $item['fields']['OuterWidth'] : null;
                $itemMaster->outer_width = (isset($item['fields']['OuterHeight'])) ? $item['fields']['OuterHeight'] : null;
                $itemMaster->unit_width = (isset($item['fields']['UnitWidth'])) ? $item['fields']['UnitWidth'] : null;
                $itemMaster->unit_height = (isset($item['fields']['UnitHeight'])) ? $item['fields']['UnitHeight'] : null;
                $itemMaster->origin = (isset($item['fields']['Origin'])) ? $item['fields']['Origin'] : null;
                $itemMaster->lot_no = (isset($item['fields']['LotNo'])) ? $item['fields']['LotNo'] : null;
                $itemMaster->bbd = (isset($item['fields']['BBD'])) ? $item['fields']['BBD'] : null;
                $itemMaster->label_remarks = (isset($item['fields']['LabelRemark'])) ? $item['fields']['LabelRemark'] : null;
                $itemMaster->lot_arr_date = (isset($item['fields']['LotArrDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LotArrDate'])) : null;
                $itemMaster->sample_date = (isset($item['fields']['SampleDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['SampleDate'])) : null;
                $itemMaster->label_photo = (isset($item['fields']['LabelPhoto'])) ? $item['fields']['LabelPhoto'] : null;
                $itemMaster->amazon_req = (isset($item['fields']['AmazInfoReq'])) ? $item['fields']['AmazInfoReq'] : null;
                $itemMaster->outer_label_pos = (isset($item['fields']['OuterLabelPos'])) ? $item['fields']['OuterLabelPos'] : null;
                $itemMaster->unit_label_pos = (isset($item['fields']['UnitLabelPos'])) ? $item['fields']['UnitLabelPos'] : null;
                $itemMaster->save();
    
                if($itemMaster){
                    if(isset($item['fields']['ProdPhoto'])){
                        foreach($item['fields']['ProdPhoto'] as $photo){
                            $image = new ItemImage();
                            $image->item_master_id = $itemMaster->id;
                            $image->url = $photo['url'];
                            $image->save();
                        }
                    }

                    if(isset($item['fields']['LabelPDF'])){
                        foreach($item['fields']['LabelPDF'] as $photo){
                            $image = new PdfItemLabel();
                            $image->item_master_id = $itemMaster->id;
                            $image->type = 'LabelPDF';
                            $image->file = $photo['url'];
                            $image->save();
                        }
                    }
                    if(isset($item['fields']['LabelAppPDF'])){
                        foreach($item['fields']['LabelAppPDF'] as $photo){
                            $image = new PdfItemLabel();
                            $image->item_master_id = $itemMaster->id;
                            $image->type = 'LabelAppPDF';
                            $image->file = $photo['url'];
                            $image->save();
                        }
                    }

                    if(isset($item['fields']['IngList_Data'])){
                        foreach($item['fields']['IngList_Data'] as $photo){
                            $image = new PdfItemLabel();
                            $image->item_master_id = $itemMaster->id;
                            $image->type = 'IngListData';
                            $image->file = $photo['url'];
                            $image->save();
                        }
                    }
    
                    if(isset($item['fields']['ClientName'])){
                        ClientItem::where('item_master_id', $itemMaster->id)->delete();
                        foreach($item['fields']['ClientName'] as $client){
                            $c = Client::where('airtable_id', $client)->first();
                            if($c){
                                $ci = new ClientItem();
                                $ci->item_master_id = $itemMaster->id;
                                $ci->client_id = $c->id;
                                $ci->save();
                            }
                        }
                    }
    
                    if(isset($item['fields']['ProdType1'])){
                        foreach($item['fields']['ProdType1'] as $client){
                            $c = ProductType::where('name', $client)->first();
                            if($c){
                                $ci = new ItemMasterProductType();
                                $ci->item_master_id = $itemMaster->id;
                                $ci->product_type_id = $c->id;
                                $ci->save();
                            }
                        }
                    }
                }
            }else{
                $itemMaster->label_link = (isset($item['fields']['Label(Link)'])) ? $item['fields']['Label(Link)'] : null; // file
                $itemMaster->label_pdf_date = (isset($item['fields']['LabelPDF_Date'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LabelPDF_Date'])) : null;
                $itemMaster->stricted_words = (isset($item['fields']['RestrictedWords1'])) ? $item['fields']['RestrictedWords1'] : null;
                $itemMaster->w_no = (isset($item['fields']['w/No'])) ? $item['fields']['w/No'] : null;
                $itemMaster->ing_list = (isset($item['fields']['IngList'])) ? $item['fields']['IngList'] : null;
                $itemMaster->label_date = (isset($item['fields']['LabelDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LabelDate'])) : null;
                $itemMaster->rec_mark = (isset($item['fields']['RECMark'])) ? json_encode($item['fields']['RECMark']) : null; //array
                $itemMaster->sampling = (isset($item['fields']['Sampling'])) ? $item['fields']['Sampling'] : null;
                $itemMaster->lot_sampling = (isset($item['fields']['LotSampling'])) ? $item['fields']['LotSampling'] : null;
                $itemMaster->product_nickname = (isset($item['fields']['愛称'])) ? $item['fields']['愛称'] : null;
                $itemMaster->outer_height = (isset($item['fields']['OuterWidth'])) ? $item['fields']['OuterWidth'] : null;
                $itemMaster->outer_width = (isset($item['fields']['OuterHeight'])) ? $item['fields']['OuterHeight'] : null;
                $itemMaster->unit_width = (isset($item['fields']['UnitWidth'])) ? $item['fields']['UnitWidth'] : null;
                $itemMaster->unit_height = (isset($item['fields']['UnitHeight'])) ? $item['fields']['UnitHeight'] : null;
                $itemMaster->origin = (isset($item['fields']['Origin'])) ? $item['fields']['Origin'] : null;
                $itemMaster->lot_no = (isset($item['fields']['LotNo'])) ? $item['fields']['LotNo'] : null;
                $itemMaster->bbd = (isset($item['fields']['BBD'])) ? $item['fields']['BBD'] : null;
                $itemMaster->label_remarks = (isset($item['fields']['LabelRemark'])) ? $item['fields']['LabelRemark'] : null;
                $itemMaster->lot_arr_date = (isset($item['fields']['LotArrDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['LotArrDate'])) : null;
                $itemMaster->sample_date = (isset($item['fields']['SampleDate'])) ? date('Y-m-d H:i:s', strtotime($item['fields']['SampleDate'])) : null;
                $itemMaster->label_photo = (isset($item['fields']['LabelPhoto'])) ? $item['fields']['LabelPhoto'] : null;
                $itemMaster->amazon_req = (isset($item['fields']['AmazInfoReq'])) ? $item['fields']['AmazInfoReq'] : null;
                $itemMaster->outer_label_pos = (isset($item['fields']['OuterLabelPos'])) ? $item['fields']['OuterLabelPos'] : null;
                $itemMaster->unit_label_pos = (isset($item['fields']['UnitLabelPos'])) ? $item['fields']['UnitLabelPos'] : null;
                $itemMaster->save();

                if(isset($item['fields']['LabelPDF'])){
                    foreach($item['fields']['LabelPDF'] as $photo){
                        $image = new PdfItemLabel();
                        $image->item_master_id = $itemMaster->id;
                        $image->type = 'LabelPDF';
                        $image->file = $photo['url'];
                        $image->save();
                    }
                }
                if(isset($item['fields']['LabelAppPDF'])){
                    foreach($item['fields']['LabelAppPDF'] as $photo){
                        $image = new PdfItemLabel();
                        $image->item_master_id = $itemMaster->id;
                        $image->type = 'LabelAppPDF';
                        $image->file = $photo['url'];
                        $image->save();
                    }
                }

                if(isset($item['fields']['IngList_Data'])){
                    foreach($item['fields']['IngList_Data'] as $photo){
                        $image = new PdfItemLabel();
                        $image->item_master_id = $itemMaster->id;
                        $image->type = 'IngListData';
                        $image->file = $photo['url'];
                        $image->save();
                    }
                }
    
                if(isset($item['fields']['ClientName'])){
                    ClientItem::where('item_master_id', $itemMaster->id)->delete();
                    foreach($item['fields']['ClientName'] as $client){
                        $c = Client::where('airtable_id', $client)->first();
                        if($c){
                            $ci = new ClientItem();
                            $ci->item_master_id = $itemMaster->id;
                            $ci->client_id = $c->id;
                            $ci->save();
                        }
                    }
                }

                if(isset($item['fields']['ProdType1'])){
                    ItemMasterProductType::where('item_master_id', $itemMaster->id)->delete();
                    foreach($item['fields']['ProdType1'] as $client){
                        $c = ProductType::where('name', $client)->first();
                        if($c){
                            $ci = new ItemMasterProductType();
                            $ci->item_master_id = $itemMaster->id;
                            $ci->product_type_id = $c->id;
                            $ci->save();
                        }
                    }
                }
            }
            
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::ITEM_MASTER);

        $this->info('Action complete');
    }
}
