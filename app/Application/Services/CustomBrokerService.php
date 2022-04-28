<?php

namespace App\Application\Services;

use Throwable;
use App\Models\CustomBroker;
use Illuminate\Http\Response;
use App\Models\WdataCustomBroker;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\CustomBrokerResource;

class CustomBrokerService extends Service
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
            $data = QueryBuilder::for(CustomBroker::Search(request('search')))
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(CustomBrokerResource::collection($data), MessageResponse::DATA_LOADED);
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
                1 => 'wdata',
                2 => 'email',
                3 => 'telephone_no',
                4 => 'fax_number',
                5 => 'created_at',
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
                    $clientLists = CustomBroker::with('wdatas.wdata');
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;

                } else {
                    $clientLists = CustomBroker::with('wdatas.wdata');
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;
                }

            } else {
                $searchKey = $request->input('search.value');
                $clientLists = CustomBroker::Search($searchKey);
                $totalClientCount = $clientLists->count();
                $clients = $clientLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalClientCount;

            }
            $tableContent = array();
            if (!empty($clients)) {
                $clientData = array();
                foreach ($clients as $client) {
                    $nestedData = array();
                    $nestedData['id'] = $client->id;
                    $nestedData['name'] = $client->name;
                    $nestedData['email'] = ($client->email != '') ? $client->email : '-';
                    $nestedData['telephone_no'] = ($client->telephone_no != '') ? $client->telephone_no : '-';
                    $nestedData['fax_number'] = ($client->fax_number != '') ? $client->fax_number : '-';
                    $nestedData['created_at'] = $client->created_at->format('M D, Y');
                    $nestedData['wdata'] = "-";
                    $count = $client->wdatas->count();
                    if($client->wdatas){
                        $nestedData['wdata'] = '';
                        foreach($client->wdatas as $index => $data){
                            $index++;
                            if($index == $count){
                                $nestedData['wdata'] .= $data->wdata->name;
                            }else{
                                $nestedData['wdata'] .= $data->wdata->name.', ';
                            }
                        }
                    }
                    $nestedData['manage_permission'] = $this->checkPermission('manage.custom.broker');
                    $clientData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalClientCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $clientData,
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
            $broker = new CustomBroker();
            $broker->name = $request->name;
            $broker->email = $request->email;
            $broker->telephone_no = $request->telephone_no;
            $broker->fax_number = $request->fax_number;
            $broker->url = $request->url;
            $broker->url_back = $request->url_back;
            $broker->data_by_matter = $request->data_by_matter;
            $broker->store_house = $request->store_house;
            $broker->test = $request->test;
            $broker->product_master = $request->product_master;
            $broker->table_70 = $request->table_17;
            $broker->warehouse_2 = $request->warehouse_2;
            $broker->address = $request->address;
            $broker->request_otsunaka = $request->request_otsunaka;
            $broker->save();

            if($broker){
                if(isset($request['wdata']) && count($request['wdata'])){
                    foreach($request['wdata'] as $id){
                        $wcb = new WdataCustomBroker();
                        $wcb->wdata_id = $id;
                        $wcb->custom_broker_id = $broker->id;
                        $wcb->save();
                    }
                }
            }

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
            $data = CustomBroker::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('amazonProgress', 'files');

            return $this->responseOk(new CustomBrokerResource($data), MessageResponse::DATA_LOADED);
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
            $broker = CustomBroker::find($id);
            $broker->name = $request->name;
            $broker->email = $request->email;
            $broker->telephone_no = $request->telephone_no;
            $broker->fax_number = $request->fax_number;
            $broker->url = $request->url;
            $broker->url_back = $request->url_back;
            $broker->data_by_matter = $request->data_by_matter;
            $broker->store_house = $request->store_house;
            $broker->test = $request->test;
            $broker->product_master = $request->product_master;
            $broker->table_70 = $request->table_17;
            $broker->warehouse_2 = $request->warehouse_2;
            $broker->address = $request->address;
            $broker->request_otsunaka = $request->request_otsunaka;
            $broker->save();

            if($broker){
                if(isset($request['wdata']) && count($request['wdata'])){
                    WdataCustomBroker::where('custom_broker_id', $broker->id)->delete();
                    foreach($request['wdata'] as $id){
                        $wcb = new WdataCustomBroker();
                        $wcb->wdata_id = $id;
                        $wcb->custom_broker_id = $broker->id;
                        $wcb->save();
                    }
                }
            }

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
            $client = CustomBroker::find($id);
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
