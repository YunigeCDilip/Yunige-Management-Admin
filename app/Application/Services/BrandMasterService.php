<?php

namespace App\Application\Services;

use Throwable;
use App\Models\Client;
use App\Models\Country;
use App\Models\BrandMaster;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\BrandMasterResource;

class BrandMasterService extends Service
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
            $data = QueryBuilder::for(BrandMaster::with('country')->Search(request('search')))
                ->defaultSort('-id')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(BrandMasterResource::collection($data), MessageResponse::DATA_LOADED);
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
                1 => 'brand_logo',
                2 => 'country_id',
                3 => 'parallel_import',
                4 => 'category',
                5 => 'check',
                6 => 'created_at',
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
                    $brandLists = BrandMaster::with('country');
                    $totalBrandCount = $brandLists->count();
                    $brands = $brandLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalBrandCount;

                } else {
                    $brandLists = BrandMaster::with('country');
                    $totalBrandCount = $brandLists->count();
                    $brands = $brandLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalBrandCount;
                }

            } else {
                $searchKey = $request->input('search.value');
                $brandLists = BrandMaster::Search($searchKey);
                $totalBrandCount = $brandLists->count();
                $brands = $brandLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalBrandCount;

            }
            $tableContent = array();
            if (!empty($brands)) {
                $brandData = array();
                foreach ($brands as $brand) {
                    $nestedData = array();
                    $nestedData['id'] = $brand->id;
                    $nestedData['name'] = $brand->name;
                    $nestedData['country_id'] = ($brand->country_id != '') ? $brand->country->name : '-';
                    $nestedData['parallel_import'] = $brand->parallel_import;
                    $nestedData['brand_logo'] = $brand->brand_logo;
                    $nestedData['category'] = ($brand->category != '') ? $brand->category : '-';
                    $nestedData['check'] = $brand->check;
                    $nestedData['created_at'] = $brand->created_at->format('M D, Y');
                    $nestedData['manage_permission'] = $this->checkPermission('manage.custom.broker');
                    $brandData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalBrandCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $brandData,
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
            $data['countries'] = Country::all();

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
            $brand = new BrandMaster();
            $brand->ja_name = $request->ja_name;
            $brand->en_name = $request->en_name;
            $brand->remarks = $request->remarks;
            $brand->country_id = $request->country;
            $brand->brand_url = $request->brand_url;
            $brand->parallel_import = $request->parallel_import;
            $brand->check = $request->check;
            $brand->category = $request->category;
            if($request->has('logo') && $request['logo']){
                $file = $request['logo'];
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('/', $fileName, 's3');
                    $brand->brand_logo = Storage::disk('s3')->url($fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
            $brand->save();

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
            $data = BrandMaster::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('country');

            return $this->responseOk(new BrandMasterResource($data), MessageResponse::DATA_LOADED);
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
            $brand = BrandMaster::find($id);
            $brand->ja_name = $request->ja_name;
            $brand->en_name = $request->en_name;
            $brand->remarks = $request->remarks;
            $brand->country_id = $request->country;
            $brand->brand_url = $request->brand_url;
            $brand->parallel_import = $request->parallel_import;
            $brand->check = $request->check;
            $brand->category = $request->category;
            if($request->has('logo') && $request['logo']){
                $file = $request['logo'];
                $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file->getClientOriginalName());  
                try{
                    $file->storeAs('/', $fileName, 's3');
                    $brand->brand_logo = Storage::disk('s3')->url($fileName);
                }catch(Throwable $e){
                    Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                }   
            }
            $brand->save();

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
            $brand = BrandMaster::find($id);
            $brand->delete();
            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
