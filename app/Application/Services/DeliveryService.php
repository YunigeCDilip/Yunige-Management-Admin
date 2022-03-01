<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\DeliveryResource;

class DeliveryService extends Service
{
    /**
     *
     * @var AirTable $contract
    */
    protected $airtable;

    public function __construct(){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::DELIVERY);
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
            if($this->getCache(AirtableDatabase::DELIVERY)){
                $data = $this->getCache(AirtableDatabase::DELIVERY);
            }else{
                $data = $this->airtable->get();
                $this->setCache(AirtableDatabase::DELIVERY, $data['records']);
            }

            return $this->responseOk(DeliveryResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
