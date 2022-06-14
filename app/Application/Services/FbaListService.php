<?php

namespace App\Application\Services;

use Throwable;
//use Carbon\Carbon;
use App\Models\FbaList;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\FbaListResource;
use App\Constants\MessageResponse;


class FbaListService extends Service
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
            $data = QueryBuilder::for(FbaList::WithQuery()->Search(request('search')))
                ->defaultSort('fba_name')
                ->allowedSorts('id', 'fba_name')
                ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(FbaListResource::collection($data), MessageResponse::DATA_LOADED);
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
                0 => 'fba_name',
                1 => 'notes',
                2 => 'label',
                3 => 'address',
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
                    $fbaList = FbaList::WithQuery();
                    $totalFbaCount = $fbaList->count();
                    $FbaLists = $fbaList->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalFbaCount;

                } else {
                    $fbaList = FbaList::WithQuery();
                    $totalFbaCount = $fbaList->count();
                    $FbaLists = $fbaList->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalFbaCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $fbaList = FbaList::WithQuery()
                    ->Search($searchKey);
                $totalFbaCount = $fbaList->count();
                $FbaLists = $fbaList->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalFbaCount;

            }
            $tableContent = array();
            if (!empty($FbaLists)) {
                $fbaData = array();
                foreach ($FbaLists as $fba) {
                    $nestedData = array();
                    $nestedData['id'] = $fba->id;
                    $nestedData['fba_name'] = $fba->fba_name;
                    $nestedData['notes'] = $fba->notes;
                    $nestedData['label'] = ($fba->label != '') ? $fba->label : '-';
                    $nestedData['address'] = ($fba->address != '') ? $fba->address : '-';
                    //$nestedData['resp_person'] = ($fba->resp_person != '') ? $fba->resp_person : '-';
                    $nestedData['manage_permission'] = $this->checkPermission('manage.fba');
                    $fbaData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalFbaCount,
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
            $data['fba'] = FbaList::select('id', 'fba_name')->get();
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
            $fba = new FbaList();
            $fba->fba_name = $request->fba_name;
            $fba->notes = $request->notes;
            $fba->label = $request->label;
            $fba->address = $request->address;
            //$fba->request = $request->request_data;
            //dd($fba);
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
            $data = FbaList::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('fba_name', 'notes', 'label', 'address');

            return $this->responseOk(new FbaListResource($data), MessageResponse::DATA_LOADED);
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
            $fba = FbaList::find($id);
            $fba->fba_name  = $request->fba_name;
            $fba->notes  = $request->notes;
            $fba->label  = $request->label;
            $fba->address  = $request->address;
           
            $fba->save();
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
            $fba = FbaList::find($id);
            $fba->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

}
