<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Domains\WarehouseDomain;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\WarehouseDataResource;

class WarehouseDataService extends Service
{
    /**
     *
     * @var Airtable $contract
     * @var ClientMasterService $clientService
     * @var DeliveryService $deliveryService
    */
    protected $airtable;
    protected $clientService;
    protected $deliveryService;

    public function __construct(
        ClientMasterService $clientService,
        DeliveryService $deliveryService
    ){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::WDATA);
        $this->airtable = new AirTable($this->apiClient);
        $this->clientService = $clientService;
        $this->deliveryService = $deliveryService;
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            if($this->getCache(AirtableDatabase::WDATA)){
                $data = $this->getCache(AirtableDatabase::WDATA);
            }else{
                $data = $this->airtable->get();
                $this->setCache(AirtableDatabase::WDATA, $data['records']);
            }
            $options['path'] = url('/').'/api/wdata';
            $response = $this->paginate(WarehouseDataResource::collection($data), request('per_page'), request('page'), $options);

            return $this->responsePaginate($response, MessageResponse::DATA_LOADED);
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
            $limit = $request->input('length');
            $start = $request->input('start');
            $search = $request->input('search')['value'];
            if($this->getCache(AirtableDatabase::WDATA)){
                $data = $this->getCache(AirtableDatabase::WDATA);
                if($search != ''){
                    $data = $data->filter(function($item) use ($search) {
                        foreach($item['fields'] as $key => $value){
                            if(!is_array($item['fields'][$key])){
                                if(stripos($item['fields'][$key],$search)){
                                    return $item;
                                }
                            }else{
                                foreach($item['fields'][$key] as $index => $v){
                                    if(!is_array($item['fields'][$key][$index]) && stripos($v,$search)){
                                        return $item;
                                    }
                                }
                            }
                        }
                    });
                }
            }else{
                $data = $this->airtable->get();
                $this->setCache(AirtableDatabase::WDATA, $data['records']);
            }
            $wDatas = [];
            $tableContent = [];
            if(isset($data) && $data){
                $wDatas = WarehouseDataResource::collection($data);
                if (!empty($data)) {
                    $tableContent = [
                        "draw" => intval($request->input('draw')),
                        "recordsTotal" => count($wDatas),
                        "recordsFiltered" => count($wDatas),
                        "data" => array_slice(json_decode($wDatas->toJson(), true), $start, $limit)
                    ];
                }
            }else{
                $tableContent = [
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => count($wDatas),
                    "recordsFiltered" => count($wDatas),
                    "data" => []
                ];
            }

            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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
            $data = $this->airtable->create(WarehouseDomain::format($request));
            if($this->getCache(AirtableDatabase::WDATA)){
                $wdatas = $this->getCache(AirtableDatabase::WDATA);
                $wdatas = array_merge([(count($wdatas) + 1) => $data->toArray()], $wdatas);
                $this->setCache(AirtableDatabase::WDATA, $wdatas);
            }else{
                $wdatas = $this->airtable->get();
                $data = array_merge([(($wdatas['records'])->count() + 1) => $data->toArray()], $wdatas['records']->toArray());
                $this->setCache(AirtableDatabase::WDATA, $data);
            }

            return $this->responseOk($data, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
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
            if($this->getCache(AirtableDatabase::WDATA.'_'.$id)){
                $data = $this->getCache(AirtableDatabase::WDATA.'_'.$id);
            }else{
                $data = $this->airtable->find($id);
                $this->setCache(AirtableDatabase::WDATA.'_'.$id, $data);
            }

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
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
            $data = $this->airtable->update($id, WarehouseDomain::format($request));
            if($this->getCache(AirtableDatabase::WDATA)){
                $this->deleteItem(AirtableDatabase::WDATA, $data, $id);
                $wdatas = $this->getCache(AirtableDatabase::WDATA);
                $wdatas = array_merge([(count($wdatas) + 1) => $data->toArray()], $wdatas);
                $this->setCache(AirtableDatabase::WDATA, $wdatas);
            }else{
                $wdatas = $this->airtable->get();
                $data = array_merge([(($wdatas['records'])->count() + 1) => $data->toArray()], $wdatas['records']->toArray());
                $this->setCache(AirtableDatabase::WDATA, $data);
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
            $data = $this->airtable->delete($id);
            if($this->getCache(AirtableDatabase::WDATA)){
                $this->deleteItem(AirtableDatabase::WDATA, $data, $id);
            }
            return $this->responseOk($data, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
}
