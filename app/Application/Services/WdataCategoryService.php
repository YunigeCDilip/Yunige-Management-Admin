<?php

namespace App\Application\Services;

use Throwable;
use App\Models\WdataCategory;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use App\Http\Resources\WdataCategoryResource;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;

class WdataCategoryService extends Service
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
            $data = QueryBuilder::for(WdataCategory::where('active_status', true)->Search(request('search')))
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(WdataCategoryResource::collection($data), MessageResponse::DATA_LOADED);
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
                1 => 'active_status',
                2 => 'created_at',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $shipperLists = WdataCategory::select('*');
                $totalShipperCount = $shipperLists->count();
                $shippers = $shipperLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalShipperCount;

            } else {
                $searchKey = $request->input('search.value');
                $shipperLists = WdataCategory::select('*')->search($searchKey);
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
                    $nestedData['active_status'] = $shipper->active_status;
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
            $data = WdataCategory::select('id', 'name', 'active_status')->get();

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
            $data = new WdataCategory();
            $data->name = $request->name;
            $data->active_status = $request->status;
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
            $data = WdataCategory::find($id);
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
            $data = WdataCategory::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            $data->name = $request->name;
            $data->active_status = $request->status;
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
            $category = WdataCategory::find($id);
            $category->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * activate/deactivate categories
     *
     * @param int $id
     * @return Response
     */
    public function activate($request)
    {
        try {
            $user = WdataCategory::find($request->id);
            $user->active_status = $request->status;
            $user->save();

            return $this->responseOk([], MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
