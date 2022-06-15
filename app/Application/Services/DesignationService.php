<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Designation;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\DesignationResource;

use Illuminate\Database\DatabaseManager;

class DesignationService extends Service
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
            $data = QueryBuilder::for(Designation::Search(request('search')))
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(DesignationResource::collection($data), MessageResponse::DATA_LOADED);
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
                $designationLists = Designation::select('*');
                $totalDesignationCount = $designationLists->count();
                $designations = $designationLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalDesignationCount;

            } else {
                $searchKey = $request->input('search.value');
                $designationLists = Designation::select('*')->search($searchKey);
                $totalDesignationCount = $designationLists->count();
                $designations = $designationLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalDesignationCount;

            }
            $tableContent = array();
            if (!empty($designations)) {
                $designationData = array();
                foreach ($designations as $designation) {
                    $nestedData = array();
                    $nestedData['id'] = $designation->id;
                    $nestedData['name'] = $designation->name;
                    $nestedData['created_at'] = $designation->created_at->toDateTimeString();
                    $designationData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalDesignationCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $designationData,
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
            $data = Designation::select('id', 'name')->get();

            return $this->responseOk(new DesignationResource($data), MessageResponse::DATA_LOADED);
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
            $data = new Designation();
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
     * @param Designation $designation
     * @return Response
     */
    public function show(Designation $designation)
    {
        try {
            $data = Designation::find($designation->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new DesignationResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Designation $designation
     * @return Response
     */
    public function update($request, Designation $designation)
    {
        try {
            $this->db->beginTransaction();
            $data = Designation::find($designation->id);
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
     * @param Designation $designation
     * @return  Response
     */
    public function destroy($request, Designation $designation)
    {
        try {
            $this->db->beginTransaction();
            $designation = Designation::find($designation->id);
            
            $designation->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
