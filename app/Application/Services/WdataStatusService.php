<?php

namespace App\Application\Services;

use Throwable;
use App\Models\WdataStatus;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use App\Http\Resources\WdataStatusResource;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;

class WdataStatusService extends Service
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
            $data = QueryBuilder::for(WdataStatus::Search(request('search')))
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(WdataStatusResource::collection($data), MessageResponse::DATA_LOADED);
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
            $columns = array(
                0 => 'name',
                1 => 'created_at',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $shipperLists = WdataStatus::select('*');
                $totalShipperCount = $shipperLists->count();
                $shippers = $shipperLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalShipperCount;

            } else {
                $searchKey = $request->input('search.value');
                $shipperLists = WdataStatus::select('*')->search($searchKey);
                $totalShipperCount = $shipperLists->count();
                $shippers = $shipperLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalShipperCount;

            }
            $tableContent = array();
            if (!empty($shippers)) {
                $shipperData = array();
                foreach ($shippers as $shipper) {
                    $nestedData = array();
                    $nestedData['id'] = $shipper->id;
                    $nestedData['name'] = $shipper->name;
                    $nestedData['created_at'] = $shipper->created_at->toDateTimeString();
                    $shipperData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalShipperCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $shipperData,
                );
            }
            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function all()
    {
        try {
            $data = WdataStatus::select('id', 'name')->get();

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
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
            $this->db->beginTransaction();
            $data = new WdataStatus();
            $data->name = $request->name;
            $data->save();

            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $data = WdataStatus::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
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
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update($request, $id)
    {
        try {
            $this->db->beginTransaction();
            $data = WdataStatus::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            $data->name = $request->name;
            $data->save();

            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($request, $id)
    {
        try {
            $this->db->beginTransaction();
            $category = WdataStatus::find($id);
            $category->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
