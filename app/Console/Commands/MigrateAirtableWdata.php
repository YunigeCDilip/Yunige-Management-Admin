<?php

namespace App\Console\Commands;

use App\Airtable\AirTable;
use Illuminate\Console\Command;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Models\Carrier;
use App\Models\CategoryWdata;
use App\Models\Container;
use App\Models\Delivery;
use App\Models\DeliveryPlace;
use App\Models\InboundStatus;
use App\Models\IncompleteStatus;
use App\Models\PickDirection;
use App\Models\Reason;
use App\Models\ShipmentMethod;
use App\Models\TrackInput;
use App\Models\Transfer;
use App\Models\WarehouseJob;
use App\Models\WarehousePic;
use App\Models\Wdata;
use App\Models\WdataAttachment;
use App\Models\WdataCategory;
use App\Models\WdataCheck;
use App\Models\WdataJob;
use App\Models\WdataPic;
use App\Models\WdataStatus;

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
            $wdata = Wdata::where('airtable_id', $item['id'])->first();
            if(!$wdata){
                $wdata = new Wdata();
            }
            if(isset($item['fields']['pic'])){
                $pic = WdataPic::where('name', $item['fields']['pic'])->first();
            }

            if(isset($item['fields']['inboundStatus'])){
                $inboundStatus = InboundStatus::where('name', $item['fields']['inboundStatus'])->first();
            }

            if(isset($item['fields']['container'])){
                $container = Container::where('name', $item['fields']['container'])->first();
            }

            if(isset($item['fields']['carrier'])){
                $carrier = Delivery::where('airtable_id', $item['fields']['carrier'])->first();
            }

            if(isset($item['fields']['deliver'])){
                $deliver = Carrier::where('name', $item['fields']['deliver'])->first();
            }

            if(isset($item['fields']['status'])){
                $status = WdataStatus::where('name', $item['fields']['status'])->first();
            }

            if(isset($item['fields']['reason'])){
                $reason = Reason::where('reason', $item['fields']['reason'])->first();
            }

            if(isset($item['fields']['trkInput'])){
                $trkInput = TrackInput::where('name', $item['fields']['trkInput'])->first();
            }

            if(isset($item['fields']['shipmentMethod'])){
                $shipmentMethod = ShipmentMethod::where('name', $item['fields']['shipmentMethod'])->first();
            }

            if(isset($item['fields']['warehousePIC'])){
                $warehousePIC = WarehousePic::where('name', $item['fields']['warehousePIC'])->first();
            }

            if(isset($item['fields']['incomplete'])){
                $incomplete = IncompleteStatus::where('name', $item['fields']['incomplete'])->first();
            }

            if(isset($item['fields']['deliveryPlace'])){
                $deliveryPlace = DeliveryPlace::where('name', $item['fields']['deliveryPlace'])->first();
            }

            if(isset($item['fields']['transfer'])){
                $transfer = Transfer::where('name', $item['fields']['transfer'])->first();
            }

            if(isset($item['fields']['pickDirection'])){
                $pickDirection = PickDirection::where('name', $item['fields']['pickDirection'])->first();
            }
            $wdata->airtable_id = $item['id'];
            $wdata->name = $item['fields']['Name'];
            $wdata->warehouse_number = isset($item['fields']['wNo']) ? $item['fields']['wNo'] : null;
            $wdata->inbound_status_id = (isset($item['fields']['inboundStatus']) && $inboundStatus) ? $inboundStatus->id : null;
            $wdata->reason_id = (isset($item['fields']['reason']) && $reason) ? $reason->id : null;
            $wdata->container_id = (isset($item['fields']['container']) && $container) ? $container->id : null;
            $wdata->carrier_id = (isset($item['fields']['deliver']) && $deliver) ? $deliver->id : null;
            $wdata->delivery_id = (isset($item['fields']['carrier']) && $carrier) ? $carrier->id : null;
            $wdata->wdata_pic_id = (isset($item['fields']['pic']) && $pic) ? $pic->id : null;
            $wdata->wdata_status_id = (isset($item['fields']['status']) && $status) ? $status->id : null;
            $wdata->inbound_eta = isset($item['fields']['inboundETA']) ? date('Y-m-d', strtotime($item['fields']['inboundETA'])) : null;
            $wdata->outbound_eta = isset($item['fields']['outboundETD']) ? date('Y-m-d', strtotime($item['fields']['outboundETD'])) : null;
            $wdata->permit_number = isset($item['fields']['permitNo']) ? $item['fields']['permitNo'] : null;
            $wdata->irregular = isset($item['fields']['irregular']) ? $item['fields']['irregular'] : null;
            $wdata->track_number = isset($item['fields']['trkNo']) ? $item['fields']['trkNo'] : null;
            $wdata->memo_invoice = isset($item['fields']['memoInvoice']) ? $item['fields']['memoInvoice'] : null;
            $wdata->pickup = isset($item['fields']['pickup']) ? $item['fields']['pickup'] : null;
            $wdata->pickup_date = isset($item['fields']['pickupDate']) ? date('Y-m-d', strtotime($item['fields']['pickupDate'])) : null;
            $wdata->free_time = isset($item['fields']['freeTime']) ? date('Y-m-d', strtotime($item['fields']['freeTime'])) : null;
            $wdata->hakamichi = isset($item['fields']['nakamichi']) ? date('Y-m-d', strtotime($item['fields']['nakamichi'])) : null;
            $wdata->delivery_date = isset($item['fields']['deliveryDate']) ? date('Y-m-d H:i:s', strtotime($item['fields']['deliveryDate'])) : null;
            $wdata->pickup_date_possible = isset($item['fields']['pickupDatePossible']) ? date('Y-m-d H:i:s', strtotime($item['fields']['pickupDatePossible'])) : null;
            $wdata->custom_broker_2 = isset($item['fields']['customBroker2']) ? $item['fields']['customBroker2'] : null;
            $wdata->inbound = isset($item['fields']['inbound']) ? $item['fields']['inbound'] : null;
            $wdata->label_status = isset($item['fields']['labelStatus']) ? $item['fields']['labelStatus'] : null;
            $wdata->paid_international = isset($item['fields']['paidInternational']) ? $item['fields']['paidInternational'] : null;
            $wdata->not_match = isset($item['fields']['notMatch']) ? $item['fields']['notMatch'] : null;
            $wdata->fba_track_no = isset($item['fields']['FBAtrkNo']) ? $item['fields']['FBAtrkNo'] : null;
            $wdata->plate_number = isset($item['fields']['plateNumber']) ? $item['fields']['plateNumber'] : null;
            $wdata->paid_tax = isset($item['fields']['paidTax']) ? $item['fields']['paidTax'] : null;
            $wdata->unknown_korea = isset($item['fields']['unknownKorea']) ? $item['fields']['unknownKorea'] : null;
            $wdata->unknown_korea2 = isset($item['fields']['unknownKorea2']) ? $item['fields']['unknownKorea2'] : null;
            $wdata->arriaval_ctn = isset($item['fields']['arrivalCTN']) ? $item['fields']['arrivalCTN'] : null;
            $wdata->memok = isset($item['fields']['memoK']) ? $item['fields']['memoK'] : null;
            $wdata->track_jp = isset($item['fields']['trkJP']) ? $item['fields']['trkJP'] : null;
            $wdata->outerdamage = isset($item['fields']['outerdamage']) ? $item['fields']['outerdamage'] : null;
            $wdata->arrival_pic_url = isset($item['fields']['arrivalPicURL']) ? $item['fields']['arrivalPicURL'] : null;
            $wdata->field_139 = isset($item['fields']['Field 139']) ? $item['fields']['Field 139'] : null;
            $wdata->invoice_memo = isset($item['fields']['invoiceMemo']) ? $item['fields']['invoiceMemo'] : null;
            $wdata->invoice_amount = isset($item['fields']['invoiceAmount']) ? $item['fields']['invoiceAmount'] : null;
            $wdata->invoice_date = isset($item['fields']['invoiceDate']) ? date('Y-m-d', strtotime($item['fields']['invoiceDate'])) : null;
            $wdata->track_input_id = (isset($item['fields']['trkInput']) && $trkInput) ? $trkInput->id : null;
            $wdata->shipment_method_id = (isset($item['fields']['shipmentMethod']) && $shipmentMethod) ? $shipmentMethod->id : null;
            $wdata->warehouse_pic_id = (isset($item['fields']['warehousePIC']) && $warehousePIC) ? $warehousePIC->id : null;
            $wdata->incomplete_status_id = (isset($item['fields']['incomplete']) && $incomplete) ? $incomplete->id : null;
            $wdata->permit_pic = isset($item['fields']['permitPic']) ? $item['fields']['permitPic'] : null;
            $wdata->delivery_place_id = (isset($item['fields']['deliveryPlace']) && $deliveryPlace) ? $deliveryPlace->id : null;
            $wdata->transfer_id = (isset($item['fields']['transfer']) && $transfer) ? $transfer->id : null;
            $wdata->pick_direction_id = (isset($item['fields']['pickDirection']) && $pickDirection) ? $pickDirection->id : null;
            // $wdata->inter_assist_inbound_id = isset($item['fields']['Name']) ? $item['fields']['Name'] : null;
            if(isset($item['createdTime'])){
                $wdata->created_at = date('Y-m-d h:i:s', strtotime($item['createdTime']));
            }
            $wdata->save();

            if($wdata){
                $check = WdataCheck::where('id', $wdata->id)->first();
                if(!$check){
                    $check = new WdataCheck();
                }

                $check->finished = isset($item['fields']['finished']) ? true : false;
                $check->wfinish = isset($item['fields']['warehouseFinish']) ? true : false;
                $check->nakamichi_finished = isset($item['fields']['nakamichiFinish']) ? true : false;
                $check->mail_sent = isset($item['fields']['mailSent']) ? true : false;
                $check->check_finished = isset($item['fields']['checkFinished']) ? true : false;
                $check->ok = isset($item['fields']['OK']) ? true : false;
                $check->check = isset($item['fields']['Check']) ? true : false;
                $check->import_permit_check = isset($item['fields']['importPermitCheck']) ? true : false;
                $check->delete_check = isset($item['fields']['deleteCheck']) ? true : false;
                $check->panel_check = isset($item['fields']['panelCheck']) ? true : false;
                $check->invoice_list = isset($item['fields']['invoiceList']) ? true : false;
                $check->wdata_id = $wdata->id;
                $check->save();

                if(isset($item['fields']['job'])){
                    foreach($item['fields']['job'] as $value){
                        $job = WarehouseJob::where('name', $value)->first();
                        if($job){
                            $wJob = new WdataJob();
                            $wJob->warehouse_job_id = $job->id;
                            $wJob->wdata_id = $wdata->id;
                            $wJob->save();
                        }
                    }
                }
                
                if(isset($item['fields']['cat'])){
                    foreach($item['fields']['cat'] as $value){
                        $job = WdataCategory::where('name', $value)->first();
                        if($job){
                            $wJob = new CategoryWdata();
                            $wJob->wdata_category_id = $job->id;
                            $wJob->wdata_id = $wdata->id;
                            $wJob->save();
                        }
                    }
                }
                
                if(isset($item['fields']['invoice'])){
                    foreach($item['fields']['invoice'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'Invoice';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['packingList'])){
                    foreach($item['fields']['packingList'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'PackingList';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['BL'])){
                    foreach($item['fields']['BL'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'BL';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['AN'])){
                    foreach($item['fields']['AN'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'AN';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['importPermit'])){
                    foreach($item['fields']['importPermit'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'ImportPermit';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['DO'])){
                    foreach($item['fields']['DO'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'DO';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['wInvoice'])){
                    foreach($item['fields']['wInvoice'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'WInvoice';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['customBInvocie'])){
                    foreach($item['fields']['customBInvocie'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'CustomBInvocie';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['FBALabel'])){
                    foreach($item['fields']['FBALabel'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'FBALabel';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['invocieKR'])){
                    foreach($item['fields']['invocieKR'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'InvocieKR';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['arrivalPic'])){
                    foreach($item['fields']['arrivalPic'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'ArrivalPic';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['arrivalPic2'])){
                    foreach($item['fields']['arrivalPic2'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'ArrivalPic';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['wDetail'])){
                    foreach($item['fields']['wDetail'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'WDetail';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }

                if(isset($item['fields']['inboundProof'])){
                    foreach($item['fields']['inboundProof'] as $value){
                        $file = new WdataAttachment();
                        $file->wdata_id = $wdata->id;
                        $file->type = 'InboundProof';
                        $file->file_name = isset($value['filename']) ? $value['filename'] : null;
                        $file->ext = isset($value['type']) ? $value['type'] : null;
                        $file->url = $value['url'];
                        $file->save();
                    }
                }
            }
        }
        $this->info('Action complete for: tablename= '.AirtableDatabase::WDATA);

        $this->info('Action complete');
    }
}
