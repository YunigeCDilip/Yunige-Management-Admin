<?php

namespace App\Application\Services;

use Throwable;
use App\Models\User;
use App\Models\Message;
use App\Jobs\SendMessages;
use App\Models\Designation;
use App\Models\UserMessage;
use App\Models\UserDesignation;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\MessageResource;
use Illuminate\Database\DatabaseManager;
use App\Http\Resources\MessageReceivedResource;

class MessageService extends Service
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
            $data = QueryBuilder::for(Message::WithQuery()->Search(request('search')))
                ->defaultSort('-id')
                ->allowedSorts('id', 'subject')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(MessageResource::collection($data), MessageResponse::DATA_LOADED);
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
    public function received()
    {
        $user = $this->getAuthUser();
        try {
            $data = QueryBuilder::for(UserMessage::withQuery()->Search(request('search')))
                ->defaultSort('-id')
                ->allowedSorts('id')
               ->paginate((request('per_page')) ?? 20);
            return $this->responsePaginate(MessageReceivedResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
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
            $data = QueryBuilder::for(Message::WithQuery())
                ->defaultSort('-id')
                ->allowedSorts('id', 'subject')
                ->get();
            return $this->responsePaginate(MessageResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
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
            $data['designations'] = Designation::select('id', 'name')->get();
            $data['users'] = User::select('id', 'name', 'email', 'active_status')->where('active_status', true)->get();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    Request  $request
     * @return  Response
     */
    public function store($request)
    {
        try {
            $auth = $this->getAuthUser();
            $this->db->beginTransaction();
            $message = new Message();
            $message->designation_id = $request->designation;
            $message->subject = $request->subject;
            $message->sender_id = $auth->id;
            $message->message = $request->message;
            $message->draft = $request->draft;
            $message->save();

            if($message){
                if(isset($request['designation']) && $request['designation'] != ''){
                    if(isset($request['user'])){
                        $message->assignUsers($request['user']);
                    }else{
                        $users = UserDesignation::where('designation_id', $request['designation'])->pluck('user_id')->toArray();
                        $message->assignUsers($users);
                    }

                }else{
                    $message->assignUsers($request['user']);
                }
            }
            if(!$request->draft){
                SendMessages::dispatch($message)->onQueue('emails');
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
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return  Response
     */
    public function update($request, $id)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy($request, $id)
    {
        try {
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
}
