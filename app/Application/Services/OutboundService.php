<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Outbound;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\OutboundResource;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\OutboundDetailResource;

class OutboundService extends Service
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
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            $data = QueryBuilder::for(Outbound::WithQuery()->Search(request('search')))
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
               
            return $this->responsePaginate(OutboundResource::collection($data), MessageResponse::DATA_LOADED);
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
            $data = Outbound::withQuery()->where('id', $id)->first();
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new OutboundDetailResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
