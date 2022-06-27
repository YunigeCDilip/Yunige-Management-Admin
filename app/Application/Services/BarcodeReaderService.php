<?php

namespace App\Application\Services;

use Throwable;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use App\Models\ItemMaster;
use App\Models\ItemMasterStore;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ItemMasterStoreResource;

class BarcodeReaderService extends Service
{
    /**
     *
     * @var DatabaseManager $db
    */
    protected $db;

    public function __construct(
        DatabaseManager $db
    ){
        $this->db = $db;
    }

    /**
     * list barcode items counts
     * @param mixed $request
     * 
     * @return mixed
     */
    public function list($request)
    {
        try {
            $data = QueryBuilder::for(ItemMasterStore::WithQuery()->Search(request('search')))
                ->defaultSort('quantity')
                ->allowedSorts('id', 'quantity')
               ->get();
            
            return $this->responseOk(ItemMasterStoreResource::collection($data), MessageResponse::DATA_FOUND);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Check barcode
     * @param mixed $request
     * 
     * @return mixed
     */
    public function checkBarcode($request)
    {
        if($request->barcode == ''){
            return $this->responseError(Response::HTTP_NOT_FOUND, 'Unable to read item barcode.');
        }

        try {
            $item = ItemMaster::where('product_barcode', $request->barcode)->first();
            if(!$item){
                return $this->responseError(Response::HTTP_NOT_FOUND, 'Barcode : '.$request->barcode.' Not Found.');
            }
            $store = ItemMasterStore::where('item_master_id', $item->id)->first();
            if(!$store){
                $store = new ItemMasterStore();
                $store->item_master_id = $item->id;
                $store->quantity = 0;
                $store->save();
            }
            $store->quantity += 1;
            $store->save();

            return $this->responseOk(new ItemMasterStoreResource($store), MessageResponse::DATA_FOUND);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError(Response::HTTP_NOT_FOUND, 'Barcode : '.$request->barcode.' Not Found');
        }
    }
}
