<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ClientMasterResource;

class ClientMasterService extends Service
{
    /**
     *
     * @var Airtable $contract
    */
    protected $airtable;

    public function __construct(){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::CLIENT_MASTER);
        $this->airtable = new AirTable($this->apiClient);
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            if($this->getCache(AirtableDatabase::CLIENT_MASTER)){
                $data = json_decode($this->getCache(AirtableDatabase::CLIENT_MASTER), true);
            }else{
                $data = $this->airtable->get();
                $this->setCache(AirtableDatabase::CLIENT_MASTER, json_encode($data['records']));
            }

            return $this->responseOk(ClientMasterResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
