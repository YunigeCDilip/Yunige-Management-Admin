<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Shipper;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use App\Http\Resources\ShipperResource;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;

class ShipperService extends Service
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
                0 => 'shipper_name',
                1 => 'created_at',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $shipperLists = Shipper::select('*');
                $totalShipperCount = $shipperLists->count();
                $shippers = $shipperLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalShipperCount;

            } else {
                $searchKey = $request->input('search.value');
                $shipperLists = Shipper::select('*')->search($searchKey);
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
                    $nestedData['shipper_name'] = $shipper->shipper_name;
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
            $data = Shipper::select('id', 'shipper_name')->get();

            return $this->responseOk(new ShipperResource($data), MessageResponse::DATA_LOADED);
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
            $data = new Shipper();
            $data->shipper_name = $request->shipper_name;
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
     * @param Shipper $shipper
     * @return Response
     */
    public function show(Shipper $shipper)
    {
        try {
            $data = Shipper::find($shipper->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new ShipperResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Shipper $shipper
     * @return Response
     */
    public function update($request, Shipper $shipper)
    {
        try {
            $this->db->beginTransaction();
            $data = Shipper::find($shipper->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            $data->shipper_name = $request->shipper_name;
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
     * @param Shipper $shipper
     * @return  Response
     */
    public function destroy($request, Shipper $shipper)
    {
        try {
            $this->db->beginTransaction();
            $shipper = Shipper::find($shipper->id);
            $isShipperUsed = Client::where('shipper_id', $shipper->id)->count();
            if($isShipperUsed > 0){
                return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, MessageResponse::NOT_DELETED);
            }
            $shipper->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
