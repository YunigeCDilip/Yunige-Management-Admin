<?php

namespace App\Application\Services;

use Throwable;
use App\Models\User;
use App\Models\Message;
use App\Jobs\SendMessages;
use App\Models\Designation;
use App\Models\UserMessage;
use App\Models\MessageDetail;
use App\Jobs\SendMessageDetail;
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

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function draft()
    {
        try {
            $data = QueryBuilder::for(Message::WithQuery()->Search(request('search'))->where('draft', true))
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
    public function trash()
    {
        try {
            $data = QueryBuilder::for(UserMessage::onlyTrashed()->withQuery()->Search(request('search')))
                ->defaultSort('-id')
                ->allowedSorts('id')
               ->paginate((request('per_page')) ?? 20);

            return $this->responsePaginate(MessageReceivedResource::collection($data), MessageResponse::DATA_LOADED);
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
     * Return required data for view.
     *
     * @return  Response
     */
    public function count()
    {
        try {
            $user = $this->getAuthUser();
            $messages = Message::toBase()
            ->selectRaw("count(case when draft = true then 1 end) as draft")
            ->selectRaw("count(case when sender_id = {$user->id} then 1 end) as sent")
            ->first();

            $data = [
                'sent' => $messages->sent,
                'received' => UserMessage::withQuery()->count(),
                'draft' => $messages->draft,
                'trash' => UserMessage::onlyTrashed()->withQuery()->count()
            ];

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
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
            $user = $this->getAuthUser();
            $data = Message::withQuery()->where('id', $id)->first();
            $userMessage = UserMessage::withTrashed()->where(['message_id' => $data->id, 'receiver_id' => $user->id])->first();
            $userMessage->read = true;
            $userMessage->save();

            return $this->responseOk(new MessageResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMessageRequest $request
     * @return Response
     */
    public function update($request)
    {
        try {
            $user = $this->getAuthUser();
            foreach($request->ids as $id){
                $message = Message::find($id);
                if($request->action == 'trash'){
                    UserMessage::where(['receiver_id' => $user->id, 'message_id' => $message->id])->delete();
                    if(isset($request['sent']) && $request['sent'] == 1){
                        $message->delete();
                    }
                }else{
                    UserMessage::where(['receiver_id' => $user->id, 'message_id' => $message->id])->update(['read' => true]);
                }
            }
            $msg = ($request->action == 'trash') ? 'Trashed successfully.' : 'Read successfully.';

            return $this->responseOk(null, $msg);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
    
    /**
     * Reply emails
     * @param Request $request
     * @param mixed $id
     * 
     * @return Response
     */
    public function reply($request, $id)
    {
        try {
            $auth = $this->getAuthUser();
            $this->db->beginTransaction();
            $message = Message::withQuery()->where('id', $id)->first();
            
            $detail = new MessageDetail();
            $detail->message_id = $message->id;
            $detail->sender_id = $auth->id;
            $detail->message = $request->message;
            $detail->save();

            UserMessage::where(['receiver_id' => $message->sender_id, 'message_id' => $message->id])->update(['read' => false]);

            if(!$request->draft){
                SendMessageDetail::dispatch($detail)->onQueue('emails');
            }

            $this->db->commit();

            return $this->responseOk(null, MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
