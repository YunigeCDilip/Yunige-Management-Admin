<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Http\Resources\WarehouseDataResource;
use Illuminate\Support\Facades\Log;

class WarehouseDataService extends Service
{
    /**
     *
     * @var Airtable $contract
    */
    protected $airtable;

    public function __construct(){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::WDATA);
        $this->airtable = new Airtable($this->apiClient);
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            $data = $this->airtable->get();

            return $this->responseOk(WarehouseDataResource::collection($data['records']), MessageResponse::DATA_LOADED);
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
            $data = $this->airtable->get();
            $wDatas = WarehouseDataResource::collection($data['records']);
            
            $tableContent = array();
            if (!empty($data)) {
                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => count($wDatas),
                    "recordsFiltered" => count($wDatas),
                    "data" => array_slice(json_decode($wDatas->toJson(), true), $start, $limit)
                );
            }
            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function all(){
        try {
            
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
    public function store($request){
        try {
            
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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
            $data = $this->airtable->find($id);

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        try {
            
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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
            
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy($request, $id)
    {
        try {
            
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
}
