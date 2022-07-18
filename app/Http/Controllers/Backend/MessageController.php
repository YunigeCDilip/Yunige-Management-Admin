<?php

namespace App\Http\Controllers\Backend;

use App\Models\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Application\Services\MessageService;

class MessageController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        MessageService $service
    )
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function index(Request $request)
    {
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.lists');

        return view('admin.email.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function received()
    {
        $data = $this->service->received();

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function sentView(Request $request)
    {
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.lists');

        return view('admin.email.sent', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function sent()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function draftView(Request $request)
    {
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.lists');

        return view('admin.email.draft', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function draft()
    {
        $data = $this->service->draft();

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function trashView(Request $request)
    {
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.lists');

        return view('admin.email.trash', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function trash()
    {
        $data = $this->service->trash();

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function count()
    {
        $data = $this->service->count();

        return $data;
    }

    /**
     * Return all active data for view.
     *
     * @return View
     */
    public function create()
    {
        $data = $this->service->create();
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.add');

        return view('admin.email.add', $data);
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function all()
    {
        $data = $this->service->all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMessageRequest $request
     * @return  Response
     */
    public function store(CreateMessageRequest $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.emails.index');
        }

        return $responseData;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $data['title'] = trans('messages.emails');
        $data['menu'] = trans('messages.emails');
        $data['subMenu'] = trans('actions.view');
        $messages = json_decode($this->service->show($id)->getContent());
        $data['message'] = $messages->payload;
        $mesg = UserMessage::withTrashed()->where(['message_id' => $id, 'receiver_id' => $user->id])->first();
        $data['trashed'] = false;
        if($mesg->deleted_at != ''){
            $data['trashed'] = true;
        }

        return view('admin.email.read', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMessageRequest $request
     * @return Response
     */
    public function update(UpdateMessageRequest $request)
    {
        $data = $this->service->update($request);

        return $data;
    }

    /**
     * Reply emails
     * @param Request $request
     * @param mixed $id
     * 
     * @return Response
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $data = json_decode($this->service->reply($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.emails.index');
        }

        return $responseData;
    }
}
