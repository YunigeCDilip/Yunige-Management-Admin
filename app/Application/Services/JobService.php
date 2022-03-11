<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use App\Http\Resources\JobResource;
use Illuminate\Support\Facades\Log;

class JobService extends Service
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
            if($this->getCache(AirtableDatabase::JOB)){
                $data = $this->getCache(AirtableDatabase::JOB);
            }else{
                $data = $this->airtable->get();
                $this->setCache(AirtableDatabase::JOB, json_encode($data['records']));
            }

            return $this->responseOk(JobResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
