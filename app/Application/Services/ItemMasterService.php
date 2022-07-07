<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Client;
use App\Models\Country;
use App\Models\Shipper;
use App\Models\ItemLabel;
use App\Models\ItemMaster;
use App\Models\BrandMaster;
use App\Models\ProductType;
use App\Models\ItemCategory;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\ItemMasterResource;

class ItemMasterService extends Service
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
            $data = QueryBuilder::for(ItemMaster::WithQuery()->Search(request('search')))
                ->defaultSort('id')
                ->allowedSorts('id', 'product_name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(ItemMasterResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function all()
    {
        try {
            $data = QueryBuilder::for(ItemMaster::WithQuery())
                ->defaultSort('id')
                ->allowedSorts('id', 'product_name')
               ->get();
            return $this->responseOk(ItemMasterResource::collection($data), MessageResponse::DATA_LOADED);
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
                1 => 'product_name',
                2 => 'images',
                3 => 'product_barcode',
                4 => 'barcode_entry_date',
                5 => 'brand_master_id',
                6 => 'item_category_id',
                7 => 'item_label_id',
                8 => 'shipper_id',
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
                    $itemLists = ItemMaster::WithQuery();
                    $totalItemCount = $itemLists->count();
                    $items = $itemLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalItemCount;

                } else {
                    $itemLists = ItemMaster::WithQuery();
                    $totalItemCount = $itemLists->count();
                    $items = $itemLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalItemCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $itemLists = ItemMaster::WithQuery()
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
                    $nestedData['product_name'] = $item->product_name;
                    $nestedData['images'] = $item->images;
                    $nestedData['brand_master_id'] = ($item->brand_master_id != '') ? $item->brands->name : '-';
                    $nestedData['item_category_id'] = ($item->item_category_id != '') ? $item->category->name : '-';
                    $nestedData['item_label_id'] = ($item->item_label_id != '') ? $item->label->name : '-';
                    $nestedData['shipper_id'] = ($item->shipper_id != '') ? $item->shipper->shipper_name : '-';
                    $nestedData['product_barcode'] = ($item->product_barcode != '') ? $item->product_barcode : '-';
                    $nestedData['barcode_entry_date'] = ($item->barcode_entry_date != '') ? $item->barcode_entry_date : '-';
                    $nestedData['manage_permission'] = $this->checkPermission('manage.client');
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

    /*
     * Return all active data for to create.
     *
     * @return array
     */
    public function create()
    {
        try {
            $data['productTypes'] = ProductType::select('id', 'name', 'active_status')->where('active_status', true)->get();
            $data['categories'] = ItemCategory::select('id', 'name')->get();
            $data['clients'] = Client::select('id', 'client_name')->get();
            $data['labels'] = ItemLabel::select('id', 'name')->get();
            $data['brands'] = BrandMaster::select('id', 'name')->get();
            $data['shippers'] = Shipper::select('id', 'shipper_name')->get();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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
            $item = new ItemMaster();
            $item->ja_name = $request->ja_name;
            $item->en_name = $request->en_name;
            $item->save();

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
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        try {
            $data = ItemMaster::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('category', 'shipper', 'label', 'clientItems.client', 'brands.country', 'productTypes.type', 'images');

            return $this->responseOk(new ItemMasterResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
    
    /**
     * Update resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update($request, $id)
    {
        try {
            $this->db->beginTransaction();
            $client = ItemMaster::find($id);
            $client->ja_name = $request->ja_name;
            $client->save();

            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
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
            $client = ItemMaster::find($id);
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
