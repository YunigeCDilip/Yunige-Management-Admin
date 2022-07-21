<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Wdata;
use App\Models\Client;
use App\Models\Shipper;
use App\Models\Wdetail;
use App\Airtable\AirTable;
use App\Models\ItemMaster;
use App\Models\WdataCheck;
use App\Models\BrandMaster;
use App\Models\WdataStatus;
use App\Models\CustomBroker;
use App\Models\ItemCategory;
use App\Models\CategoryWdata;
use App\Models\ClientContact;
use App\Models\InboundStatus;
use App\Models\WdataCategory;
use Illuminate\Http\Response;
use App\Models\ShipmentMethod;
use App\Models\WdataAttachment;
use App\Domains\WarehouseDomain;
use App\Models\ClientAttachment;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\DatabaseManager;
use App\Application\Services\UserService;
use App\Http\Resources\ItemMasterResource;
use App\Http\Resources\WdataDetailResource;
use App\Http\Resources\ClientMasterResource;
use App\Http\Resources\WarehouseDataResource;
use App\Models\ClientWdata;
use App\Models\WdataCustomBroker;

class WarehouseDataService extends Service
{
    /**
     *
     * @var Airtable $contract
     * @var ClientMasterService $clientService
     * @var DeliveryService $deliveryService
     * @var UserService $userService
     * @var ItemMasterService $itemService
     * @var DatabaseManager $db
    */
    protected $airtable;
    protected $clientService;
    protected $deliveryService;
    protected $userService;
    protected $itemService;
    protected $db;

    public function __construct(
        ClientMasterService $clientService,
        DeliveryService $deliveryService,
        UserService $userService,
        ItemMasterService $itemService,
        DatabaseManager $db
    ){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::WDATA);
        $this->airtable = new AirTable($this->apiClient);
        $this->clientService = $clientService;
        $this->deliveryService = $deliveryService;
        $this->itemService = $itemService;
        $this->userService = $userService;
        $this->db = $db;
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            $data = QueryBuilder::for(Wdata::WithQuery()->Search(request('search')))
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
               
            return $this->responsePaginate(WarehouseDataResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * return all datatable resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatable($request)
    {
        try {
            $columns = array(
                0 => 'id',
                1 => 'Name',
                2 => 'clientName',
                3 => 'permitNo',
                4 => 'trkNo',
                5 => 'deliver',
                6 => 'cat',
                7 => 'status',
                8 => 'createdTime',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $itemLists = Wdata::WithQuery();
                $totalItemCount = $itemLists->count();
                $items = $itemLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalItemCount;

            } else {
                $searchKey = $request->input('search.value');
                $itemLists = Wdata::WithQuery()
                    ->Search($searchKey);
                $totalItemCount = $itemLists->count();
                $items = $itemLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalItemCount;

            }
            $tableContent = array();
            if (!empty($items)) {
                $itemData = WarehouseDataResource::collection($items);

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalItemCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => json_decode($itemData->toJson(), true),
                );
            }
            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return all active data for to create.
     *
     * @return array
     */
    public function create()
    {
        try {
            $clients = json_decode($this->clientService->all()->getContent());
            $delivery = json_decode($this->deliveryService->all()->getContent());
            $users = json_decode($this->userService->all()->getContent());
            $items = json_decode($this->itemService->all()->getContent());
            $data['pic'] = WarehouseDomain::pic();
            $data['cat'] = WarehouseDomain::cat();
            $data['status'] = WdataStatus::all();
            $data['jobs'] = WarehouseDomain::job();
            $data['inboundStatus'] = InboundStatus::all();
            $data['shippers'] = Shipper::all();
            $data['categories'] = ItemCategory::all();
            $data['labelingStatus'] = WarehouseDomain::labelingStatus();
            $data['workInstructions'] = WarehouseDomain::workInstructions();
            $data['shipments'] = ShipmentMethod::all();
            $data['customBrokers'] = CustomBroker::select('id', 'name')->get();
            $data['brands'] = BrandMaster::select('id', 'name')->get();
            $data['clients'] = $clients->payload;
            $data['carrier'] = $delivery->payload;
            // w project charge
            $data['users'] = $users->payload;
            $data['items'] = $items->payload;

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($request)
    {
        try {
            $this->db->beginTransaction();

            $wdata = new Wdata();
            $wdata->incharge_id = $request->project_charge;
            $wdata->transport_method = $request->transport;
            $wdata->memok = $request->incoterms;
            $wdata->carrier_id = $request->arrival_place;
            $wdata->shipment_method_id = $request->shipping_company;
            $wdata->track_number = $request->track_number;
            $wdata->inbound_eta = $request->eta;
            $wdata->case_count = $request->document_case;
            $wdata->wdata_status_id = $request->arrival_progress;
            $wdata->inbound_status_id = $request->goods_progress;
            $wdata->irregular = $request->overal_work_instruction;
            $wdata->save();
            if($wdata){
                $check = WdataCheck::where('id', $wdata->id)->first();
                if(!$check){
                    $check = new WdataCheck();
                    $check->wdata_id = $wdata->id;
                }
                $check->save();

                if($request->customs_broker != ''){
                    $cb = new WdataCustomBroker();
                    $cb->wdata_id = $wdata->id;
                    $cb->custom_broker_id = $request->customs_broker;
                    $cb->save();
                }

                $client = new ClientWdata();
                $client->wdata_id = $wdata->id;
                $client->client_id = $request->client;
                $client->save();

                $cat = new CategoryWdata();
                $cat->wdata_category_id = $request->category;
                $cat->wdata_id = $wdata->id;
                $cat->save();
                
                foreach($request['items'] as $index => $item){
                    $wdatad = new Wdetail();
                    $wdatad->wdata_id = $wdata->id;
                    $wdatad->item_master_id = $item[$index]['product'];
                    $wdatad->labeling_status = $item[$index]['labeling_status'];
                    $wdatad->work_progress = implode(",", $item[$index]['reg_work_inst']);
                    $wdatad->est_qty = $item[$index]['warehouse_qty'];
                    $wdatad->fnsku_or_not = $item[$index]['fnsku_not_req'];
                    $wdatad->work_instruction = $item[$index]['ireg_work_inst'];
                }

                if(isset($request['invoice']) && count($request['invoice']) > 0){
                    foreach($request['invoice'] as $value){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'invoice-'.$value->getClientOriginalName());  
                        try{
                            $file = new WdataAttachment();
                            $file->wdata_id = $wdata->id;
                            $file->type = 'Invoice';
                            $file->file_name = $fileName;
                            $file->ext = $value->getClientOriginalExtension();
                            $file->url = Storage::disk('s3')->url($fileName);
                            $file->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
                    }
                }

                if(isset($request['packing']) && count($request['packing']) > 0){
                    foreach($request['packing'] as $value){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'packing-'.$value->getClientOriginalName());  
                        try{
                            $file = new WdataAttachment();
                            $file->wdata_id = $wdata->id;
                            $file->type = 'PackingList';
                            $file->file_name = $fileName;
                            $file->ext = $value->getClientOriginalExtension();
                            $file->url = Storage::disk('s3')->url($fileName);
                            $file->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
                    }
                }

                if(isset($request['bl']) && count($request['bl']) > 0){
                    foreach($request['bl'] as $value){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'bl-'.$value->getClientOriginalName());  
                        try{
                            $file = new WdataAttachment();
                            $file->wdata_id = $wdata->id;
                            $file->type = 'BL';
                            $file->file_name = $fileName;
                            $file->ext = $value->getClientOriginalExtension();
                            $file->url = Storage::disk('s3')->url($fileName);
                            $file->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
                    }
                }

                if(isset($request['an']) && count($request['an']) > 0){
                    foreach($request['an'] as $value){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'an-'.$value->getClientOriginalName());  
                        try{
                            $file = new WdataAttachment();
                            $file->wdata_id = $wdata->id;
                            $file->type = 'AN';
                            $file->file_name = $fileName;
                            $file->ext = $value->getClientOriginalExtension();
                            $file->url = Storage::disk('s3')->url($fileName);
                            $file->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
                    }
                }
            }

            return $this->responseOk(null, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        try {
            $data = Wdata::withQuery()->where('id', $id)->first();
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new WdataDetailResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return  Response
     */
    public function update($request, $id)
    {
        try {
            $data = $this->airtable->update($id, WarehouseDomain::formatUpdateRequest($request));
            if(isset($data['error'])){
                return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, $data['error']['message']);
            }
            $this->forgetCache(AirtableDatabase::WDATA.'_'.$id);
            if($this->getCache(AirtableDatabase::WDATA)){
                $this->deleteItem(AirtableDatabase::WDATA, json_encode($data), $id);
                $wdatas = json_decode($this->getCache(AirtableDatabase::WDATA), true);
                $wdatas = array_merge([(count($wdatas) + 1) => $data->toArray()], array_filter($wdatas));
                $this->setCache(AirtableDatabase::WDATA, json_encode($wdatas));
            }else{
                $wdatas = $this->airtable->get();
                $data = array_merge([(($wdatas['records'])->count() + 1) => $data->toArray()], $wdatas['records']->toArray());
                $this->setCache(AirtableDatabase::WDATA, json_encode($data));
            }

            return $this->responseOk($data, MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($request, $id)
    {
        try {
            $wdata = $this->airtable->find($id);
            $this->forgetCache(AirtableDatabase::WDATA.'_'.$id);
            if(isset($wdata['error'])){
                if($this->getCache(AirtableDatabase::WDATA)){
                    $this->deleteItem(AirtableDatabase::WDATA, json_encode($wdata), $id);
                }
            }else{
                $data = $this->airtable->delete($id);
                if(isset($data['error'])){
                    return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, $data['error']['message']);
                }
                if($this->getCache(AirtableDatabase::WDATA)){
                    $this->deleteItem(AirtableDatabase::WDATA, json_encode($wdata), $id);
                }
            }
            return $this->responseOk([], MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Save client on Wdata form
     *
     * @param $request
     * @return Response
     */
    public function saveClient($request)
    {
        try {
            $this->db->beginTransaction();
            $client = new Client();
            $client->incharge_id = $request->incharge;
            $client->ja_name = $request->ja_name;
            $client->en_name = $request->en_name;
            $client->shipper_id = $request->shipper;
            $client->hp = $request->hp;
            $client->company_tel = $request->company_tel;
            $client->fax = $request->fax;
            $client->customer_memo = $request->customer_memo;
            $client->save();

            if($client){
                $contact = new ClientContact();
                $contact->client_id = $client->id;
                $contact->name = $request->person_name;
                $contact->office_add = $request->office_add;
                $contact->email = $request->email;
                $contact->contact_number = $request->contact_number;
                $contact->seller_name = $request->amazon_listed;
                $contact->seller_add = $request->amazon_listed_address;
                $contact->delivery_address = $request->delivery_address;
                $contact->save();


                if(isset($request['food'])){
                    foreach($request['food'] as $attach){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'client'.$attach->extension());
                        Storage::disk('s3')->put($fileName, $attach);
                        $file = new ClientAttachment();
                        $file->client_id = $client->id;
                        $file->type = '食品届';
                        $file->file_name = $fileName;
                        $file->ext = $attach->extension();
                        $file->url = Storage::disk('s3')->url($fileName);
                        $file->save();
                    }
                }
            }

            $this->db->commit();

            return $this->responseOk(new ClientMasterResource($client), MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Save item on Wdata form
     *
     * @param $request
     * @return Response
     */
    public function saveItem($request)
    {
        $data = ItemMaster::first();
        
        return $this->responseOk(new ItemMasterResource($data), MessageResponse::DATA_CREATED);
        try {
            $this->db->beginTransaction();
            $client = new Client();
            $client->incharge_id = $request->incharge;
            $client->ja_name = $request->ja_name;
            $client->en_name = $request->en_name;
            $client->shipper_id = $request->shipper;
            $client->hp = $request->hp;
            $client->company_tel = $request->company_tel;
            $client->fax = $request->fax;
            $client->customer_memo = $request->customer_memo;
            $client->save();

            if($client){
                $contact = new ClientContact();
                $contact->client_id = $client->id;
                $contact->name = $request->person_name;
                $contact->office_add = $request->office_add;
                $contact->email = $request->email;
                $contact->contact_number = $request->contact_number;
                $contact->seller_name = $request->amazon_listed;
                $contact->seller_add = $request->amazon_listed_address;
                $contact->delivery_address = $request->delivery_address;
                $contact->save();


                if(isset($request['food'])){
                    foreach($request['food'] as $attach){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'client'.$attach->extension());
                        Storage::disk('s3')->put($fileName, $attach);
                        $file = new ClientAttachment();
                        $file->client_id = $client->id;
                        $file->type = '食品届';
                        $file->file_name = $fileName;
                        $file->ext = $attach->extension();
                        $file->url = Storage::disk('s3')->url($fileName);
                        $file->save();
                    }
                }
            }

            $this->db->commit();

            return $this->responseOk(new ClientMasterResource($client), MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
