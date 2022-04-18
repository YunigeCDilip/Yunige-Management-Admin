<?php

namespace App\Application\Services;

use Throwable;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Response;
use App\Models\AmazonProgress;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use App\Models\ClientAmazonProgress;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\DatabaseManager;
use App\Models\Models\AmazonProgressFile;
use App\Http\Resources\AmazonProgressResource;

class AmazonProgressService extends Service
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
            $data = QueryBuilder::for(AmazonProgress::WithQuery()->Search(request('search')))
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(AmazonProgressResource::collection($data), MessageResponse::DATA_LOADED);
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
                1 => 'status',
                2 => 'pickup',
                3 => 'memo',
                4 => 'done',
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
                    $clientLists = AmazonProgress::select('*');
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;

                } else {
                    $clientLists = AmazonProgress::select('*');
                    $totalClientCount = $clientLists->count();
                    $clients = $clientLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalClientCount;

                }

            } else {
                $searchKey = $request->input('search.value');
                $clientLists = AmazonProgress::Search($searchKey);
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
                    $nestedData['status'] = ($client->status != '') ? $client->status : '-';
                    $nestedData['pickup'] = ($client->pickup != '') ? $client->pickup : '-';
                    $nestedData['memo'] = ($client->memo != '') ? $client->memo : '-';
                    $nestedData['done'] = $client->done;
                    $nestedData['manage_permission'] = $this->checkPermission('manage.amazon.progress');
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
            $data['clients'] = Client::select('id', 'client_name')->get();
            $data['users'] = User::select('id', 'name', 'active_status')->where('active_status', 1)->get();

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
            $amazon = new AmazonProgress();
            $amazon->status = $request->client."_".$request->status;
            $amazon->pickup = $request->pickup;
            $amazon->user_id = $request->user;
            $amazon->memo = $request->memo;
            $amazon->done = $request->done;
            $amazon->champain = $request->compaign;
            $amazon->translation = $request->translation;
            $amazon->save();

            if($amazon){
                $ac = new ClientAmazonProgress();
                $ac->client_id = $request->client;
                $ac->amazon_progress_id = $amazon->id;
                $ac->save();

                if($request->has('attachments') && count($request['attachments']) > 0){
                    foreach($request->attachments as $index => $file){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file->getClientOriginalName());  
                        try{
                            $file->storeAs('/', $fileName, 's3');
                            $aFile = new AmazonProgressFile();
                            $aFile->amazon_progress_id = $amazon->id;
                            $aFile->url = Storage::disk('s3')->url($fileName);
                            $aFile->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
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
            $data = AmazonProgress::find($id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }
            $data->load('amazonProgress', 'files');

            return $this->responseOk(new AmazonProgressResource($data), MessageResponse::DATA_LOADED);
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
            $amazon = AmazonProgress::find($id);
            $amazon->status = $request->client."_".$request->status;
            $amazon->pickup = $request->pickup;
            $amazon->user_id = $request->user;
            $amazon->memo = $request->memo;
            $amazon->done = $request->done;
            $amazon->champain = $request->compaign;
            $amazon->translation = $request->translation;
            $amazon->save();

            if($amazon){
                $ac = ClientAmazonProgress::where('client_id', $request->client)->first();
                if($ac){
                    $ac->client_id = $request->client;
                    $ac->save();
                }else{
                    $ac = new ClientAmazonProgress();
                    $ac->client_id = $request->client;
                    $ac->amazon_progress_id = $amazon->id;
                    $ac->save();
                }
                
                if($request->has('attachments') && count($request['attachments']) > 0){
                    foreach($request->attachments as $index => $file){
                        $fileName = str_replace(['#', '/', '\\', ' '], '-', time().'am-'.$file->getClientOriginalName());  
                        try{
                            $file->storeAs('/', $fileName, 's3');
                            $aFile = new AmazonProgressFile();
                            $aFile->amazon_progress_id = $amazon->id;
                            $aFile->url = Storage::disk('s3')->url($fileName);
                            $aFile->save();
                        }catch(Throwable $e){
                            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
                        }   
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
            $client = AmazonProgress::find($id);
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
     * @param int $id
     * @return Response
     */
    public function deleteFile($id)
    {
        try {
            $this->db->beginTransaction();
            $client = AmazonProgressFile::find($id);
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
