<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\BarcodeItem;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckBarcodeRequest;
use App\Http\Resources\BarcodeItemResource;

class BarcodeItemController extends Controller
{
    use ResponseTrait;

    /**
     * check barcode if present
     * @var CheckBarcodeRequest $request
     * @return Response
     */
    public function index(CheckBarcodeRequest $request)
    {
        try {
            $data = BarcodeItem::WhereBarcode($request->barcode)->first();
            if(!$data){
                return $this->responseOk(null, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new BarcodeItemResource($data), MessageResponse::DATA_FOUND);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
