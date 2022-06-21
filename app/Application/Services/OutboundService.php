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
                0 => 'id',
                1 => 'name',
                2 => 'wdata_id',
                3 => 'warehouse_in_charge',
                4 => 'reserve',
                5 => 'ship_date',
                6 => 'delivery_id',
                7 => 'create_date',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $dat = array();
            $datas = array();
            if (empty($request->input('search.value'))) {
                for ($i = 1; $i < count($request->columns); $i++) {
                    if (isset($request->columns[$i]['search']['value'])) {
                        $dat[$request->columns[$i]['data']] = $request->columns[$i]['search']['value'];
                    }
                    $datas = $dat;
                }

                if (!empty($datas)) {
                    $itemLists = Outbound::WithQuery();
                    $totalItemCount = $itemLists->count();
                    $items = $itemLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalItemCount;

                } else {
                    $itemLists = Outbound::WithQuery();
                    $totalItemCount = $itemLists->count();
                    $items = $itemLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalItemCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $itemLists = Outbound::WithQuery()
                    ->Search($searchKey);
                $totalItemCount = $itemLists->count();
                $items = $itemLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalItemCount;

            }
            $tableContent = array();
            if (!empty($items)) {
                $itemData = array();
                foreach ($items as $item) {
                    $nestedData = array();
                    $nestedData['id'] = $item->id;
                    $nestedData['name'] = $item->name;
                    $nestedData['wdata_id'] = ($item->wdata) ? $item->wdata->name : '-';
                    $nestedData['warehouse_in_charge'] = $item->warehouse_in_charge;
                    $nestedData['reserve'] = $item->reserve;
                    $nestedData['ship_date'] = ($item->ship_date != '') ? date('F d, Y', strtotime($item->ship_date)) : '-';
                    $nestedData['delivery_id'] = ($item->delivery_id != '') ? $item->delivery->name : '-';
                    $nestedData['create_date'] = ($item->create_date != '') ? date('F d, Y', strtotime($item->create_date)) : '-';
                    $nestedData['manage_permission'] = $this->checkPermission('manage.outbound');
                    $itemData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalItemCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $itemData,
                );
            }
            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function destroy($request, $id)
    {
        try {
            $this->db->beginTransaction();
            $client = Outbound::find($id);
            $client->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
