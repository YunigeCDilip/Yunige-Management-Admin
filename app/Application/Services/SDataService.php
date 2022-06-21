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
                1 => 'case_number',
                2 => 'by_country',
                3 => 'case_in_charge',
                4 => 'matter_date',
                5 => 'priority',
                6 => 'ingredient_progress',
                7 => 'notification_progress',
                8 => 'sample_progress',
                9 => 'label_creation_progress',
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
                    $sdataList = Sdata::WithQuery();
                    $totalSdataCount = $sdataList->count();
                    $sdataLists = $sdataList->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalSdataCount;

                } else {
                    $sdataList = Sdata::WithQuery();
                    $totalSdataCount = $sdataList->count();
                    $sdataLists = $sdataList->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalSdataCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $sdataList = Sdata::WithQuery()
                    ->Search($searchKey);
                $totalSdataCount = $sdataList->count();
                $sdataLists = $sdataList->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalSdataCount;

            }
            $tableContent = array();
            if (!empty($sdataLists)) {
                $fbaData = array();
                foreach ($sdataLists as $sdata) {
                    $nestedData = array();
                    $nestedData['id'] = $sdata->id;
                    $nestedData['name'] = $sdata->name;
                    $nestedData['case_number'] = $sdata->case_number;
                    $nestedData['by_country'] = ($sdata->by_country != '') ? $sdata->by_country : '-';
                    $nestedData['case_in_charge'] = ($sdata->case_in_charge != '') ? $sdata->case_in_charge : '-';
                    $nestedData['matter_date'] = ($sdata->matter_date != '') ? $sdata->matter_date : '-';
                    $nestedData['priority'] = ($sdata->priority != '') ? $sdata->priority : '-';
                    $nestedData['ingredient_progress'] = ($sdata->ingredient_progress != '') ? $sdata->ingredient_progress : '-';
                    $nestedData['notification_progress'] = ($sdata->notification_progress != '') ? $sdata->notification_progress : '-';
                    $nestedData['sample_progress'] = ($sdata->sample_progress != '') ? $sdata->sample_progress : '-';
                    $nestedData['label_creation_progress'] = ($sdata->label_creation_progress != '') ? $sdata->label_creation_progress : '-';
                    $nestedData['manage_permission'] = $this->checkPermission('manage.sdata');
                    $fbaData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalSdataCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $fbaData,
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
            $data['sdata'] = Sdata::select('id', 'name')->get();
            //$data['movements'] = MovementConfirmation::select('id', 'name')->get();

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
            $fba = new Sdata();
            $fba->name = $request->name;
            $fba->case_number = $request->case_number;
            $fba->by_country = $request->by_country;
            $fba->case_in_charge = $request->case_in_charge;
            $fba->memo = $request->memo;
            $fba->matter_date = $request->matter_date;
            $fba->priority = $request->priority;
            $fba->ingredient_progress = $request->ingredient_progress;
            $fba->notification_progress = $request->notification_progress;
            $fba->sample_progress = $request->sample_progress;
            $fba->label_creation_progress = $request->label_creation_progress;
            $fba->save();

            $this->db->commit();
            return $this->responseOk(null, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            //dd($request->fba_name);
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
