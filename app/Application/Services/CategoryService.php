<?php

namespace App\Application\Services;

use Throwable;
use App\Domains\WarehouseDomain;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;

class CategoryService extends Service
{
    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            $data = WarehouseDomain::cat();

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
