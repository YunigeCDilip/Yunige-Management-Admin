<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Sdata;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use App\Http\Resources\SDataDetailResource;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\SDataResource;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;

class SDataService extends Service
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
            $data = QueryBuilder::for(Sdata::WithQuery()->Search(request('search')))
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
               
            return $this->responsePaginate(SDataResource::collection($data), MessageResponse::DATA_LOADED);
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
            $data = Sdata::withQuery()->where('id', $id)->first();
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new SDataDetailResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
