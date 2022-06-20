<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Wdata;
use App\Airtable\AirTable;
use Illuminate\Http\Response;
use App\Domains\WarehouseDomain;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\WdataDetailResource;
use App\Http\Resources\WarehouseDataResource;

class WarehouseDataService extends Service
{
    /**
     *
     * @var Airtable $contract
     * @var ClientMasterService $clientService
     * @var DeliveryService $deliveryService
     * @var DatabaseManager $db
    */
    protected $airtable;
    protected $clientService;
    protected $deliveryService;
    protected $db;

    public function __construct(
        ClientMasterService $clientService,
        DeliveryService $deliveryService,
        DatabaseManager $db
    ){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::WDATA);
        $this->airtable = new AirTable($this->apiClient);
        $this->clientService = $clientService;
        $this->deliveryService = $deliveryService;
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
            $clients = json_decode($this->clientService->index()->getContent());
            $delivery = json_decode($this->deliveryService->index()->getContent());
            $data['pic'] = WarehouseDomain::pic();
            $data['cat'] = WarehouseDomain::cat();
            $data['status'] = WarehouseDomain::status();
            $data['jobs'] = WarehouseDomain::job();
            $data['inboundStatus'] = WarehouseDomain::inboundStatus();
            $data['clients'] = $clients->payload;
            $data['carrier'] = $delivery->payload;

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
            
            $data = $this->airtable->create(WarehouseDomain::format($request));
            if(isset($data['error'])){
                return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, $data['error']['message']);
            }
            if($this->getCache(AirtableDatabase::WDATA)){
                $wdatas = json_decode($this->getCache(AirtableDatabase::WDATA), true);
                $wdatas = array_merge([(count($wdatas) + 1) => $data->toArray()], array_filter($wdatas));
                $this->setCache(AirtableDatabase::WDATA, json_encode($wdatas));
            }else{
                $wdatas = $this->airtable->get();
                $data = array_merge([(($wdatas['records'])->count() + 1) => $data->toArray()], $wdatas['records']->toArray());
                $this->setCache(AirtableDatabase::WDATA, json_encode($data));
            }
            $this->db->commit();

            return $this->responseOk($data, MessageResponse::DATA_CREATED);
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
}
