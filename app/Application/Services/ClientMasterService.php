<?php

namespace App\Application\Services;

use Throwable;
use Carbon\Carbon;
use App\Models\Sdata;
use App\Models\Wdata;
use App\Models\Client;
use App\Models\Shipper;
use App\Models\ItemMaster;
use App\Models\ClientContact;
use Illuminate\Http\Response;
use App\Models\AmazonProgress;
use App\Models\ClientCategory;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use App\Models\MovementConfirmation;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\ClientMasterResource;
use App\Models\ClientBrand;
use App\Models\ForeignDeliveryClassification;

class ClientMasterService extends Service
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
            $data = QueryBuilder::for(Client::WithQuery()->Search(request('search')))
                ->defaultSort('client_name')
                ->allowedSorts('id', 'client_name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(ClientMasterResource::collection($data), MessageResponse::DATA_LOADED);
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
                0 => 'serial_number',
                1 => 'client_name',
                2 => 'category_name',
                3 => 'shipper_name',
                4 => 'resp_person',
                5 => 'contact_no'
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
                    $clientLists = Client::WithQuery();
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;

                } else {
                    $clientLists = Client::WithQuery();
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $clientLists = Client::WithQuery()
                    ->Search($searchKey);
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
                    $nestedData['serial_number'] = $client->serial_number;
                    $nestedData['client_name'] = $client->client_name;
                    $nestedData['shipper_name'] = ($client->shipper_name != '') ? $client->shipper_name : '-';
                    $nestedData['category_name'] = ($client->category_name != '') ? $client->category_name : '-';
                    $nestedData['resp_person'] = ($client->resp_person != '') ? $client->resp_person : '-';
                    $nestedData['contact_no'] = ($client->contact_number != '') ? $client->contact_number : '-';
                    $nestedData['manage_permission'] = $this->checkPermission('manage.client');
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
            $data['items'] = ItemMaster::select('id', 'product_name')->get();
            $data['movements'] = MovementConfirmation::select('id', 'name')->get();
            $data['shippers'] = Shipper::select('id', 'shipper_name')->get();
            $data['classifications'] = ForeignDeliveryClassification::select('id', 'name')->get();
            $data['categories'] = ClientCategory::select('id', 'name')->get();
            $data['clients'] = Client::select('id', 'client_name')->get();
            $data['sdatas'] = Sdata::select('id', 'name')->get();
            $data['wdatas'] = Wdata::select('id', 'name')->get();
            $data['amazons'] = AmazonProgress::select('id', 'name')->get();

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
            $client = new Client();
            $client->ja_name = $request->ja_name;
            $client->en_name = $request->en_name;
            $client->shipper_id = $request->shipper;
            $client->hp = $request->hp;
            $client->request = $request->request_data;
            $client->warehouse_remarks = $request->warehouse_remarks;
            $client->customer_classification = $request->customer_classification;
            $client->invoice = $request->invoice_memo;
            $client->company_tel = $request->company_tel;
            $client->fax = $request->fax;
            $client->warehouse_mgnt_copy = $request->warehouse_mgnt_copy;
            $client->movement_confirmation_id = $request->movement;
            $client->request_client_id = $request->client;
            $client->work_management = $request->work_management;
            $client->sugio_book_print = ($request->has('sugio_book_print')) ? true : false;
            $client->yamazaki_book_print = ($request->has('yamazaki_book_print')) ? true : false;
            $client->foreign_delivery_classifications_id = $request->delivery_classification;
            $client->takatsu_working_date = Carbon::parse($request->takatsu_working_date)->format('Y-m-d H:i:s');
            $client->client_category_id = $request->category;
            $client->save();

            if($client){
                $contact = new ClientContact();
                $contact->client_id = $client->id;
                $contact->name = $request->person_name;
                $contact->office_add = $request->office_add;
                $contact->email = $request->email;
                $contact->contact_number = $request->contact_number;
                $contact->seller_name = $request->seller_name;
                $contact->seller_add = $request->seller_add;
                $contact->pic_add = $request->pic_add;
                $contact->save();

                $client->saveClientsDatas($request);
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
            $data = Client::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('contact', 'amazonProgress.progress', 'items', 'sdatas.sdata', 'wdatas', 'shipper', 'category', 'requestedClient', 'movement', 'classification');

            return $this->responseOk(new ClientMasterResource($data), MessageResponse::DATA_LOADED);
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
            $client = Client::find($id);
            $client->ja_name = $request->ja_name;
            $client->en_name = $request->en_name;
            $client->shipper_id = $request->shipper;
            $client->hp = $request->hp;
            $client->request = $request->request_data;
            $client->warehouse_remarks = $request->warehouse_remarks;
            $client->customer_classification = $request->customer_classification;
            $client->invoice = $request->invoice_momo;
            $client->company_tel = $request->company_tel;
            $client->fax = $request->fax;
            $client->warehouse_mgnt_copy = $request->warehouse_mgnt_copy;
            $client->movement_confirmation_id = $request->movement;
            $client->request_client_id = $request->client;
            $client->work_management = $request->work_management;
            $client->sugio_book_print = ($request->has('sugio_book_print')) ? true : false;
            $client->yamazaki_book_print = ($request->has('yamazaki_book_print')) ? true : false;
            $client->foreign_delivery_classifications_id = $request->delivery_classification;
            $client->takatsu_working_date = Carbon::parse($request->takatsu_working_date)->format('Y-m-d H:i:s');
            $client->client_category_id = $request->category;
            $client->save();

            if($client){
                $contact = ClientContact::where('client_id', $client->id)->first();
                $contact->name = $request->person_name;
                $contact->office_add = $request->office_add;
                $contact->email = $request->email;
                $contact->contact_number = $request->contact_number;
                $contact->seller_name = $request->seller_name;
                $contact->seller_add = $request->seller_add;
                $contact->pic_add = $request->pic_add;
                $contact->save();

                $client->saveClientsDatas($request);
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
            $client = Client::find($id);
            $client->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
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
     * @return Response
     */
    public function deleteBrand($request)
    {
        try {
            $this->db->beginTransaction();
            $client = ClientBrand::find($request->id);
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
