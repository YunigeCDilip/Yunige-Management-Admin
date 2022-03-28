<?php

namespace App\Application\Services;

use Throwable;
use App\Airtable\AirTable;
use App\Constants\MessageResponse;
use App\Airtable\AirtableApiClient;
use App\Constants\AirtableDatabase;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ClientMasterResource;
use App\Models\Client;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ClientMasterService extends Service
{
    /**
     *
     * @var Airtable $contract
    */
    protected $airtable;

    public function __construct(){
        $this->apiClient = new AirtableApiClient(AirtableDatabase::CLIENT_MASTER);
        $this->airtable = new AirTable($this->apiClient);
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            // $clients = Client::WithQuery();
            $data = QueryBuilder::for(Client::WithQuery()->Search(request('search')))
                ->defaultSort('client_name')
                ->allowedSorts('id', 'client_name')
               ->paginate((request('per_page')) ?? 20);
            // return $data;
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
                    ->FilterByGlobalSearch($searchKey);
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
}
