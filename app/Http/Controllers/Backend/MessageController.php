<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\MessageService;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

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
    public function received()
    {
        $data = $this->service->received();

        return $data;
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

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        $data = $this->service->edit($id);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMessageRequest $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateMessageRequest $request, $id)
    {
        $data = $this->service->update($request, $id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->service->destroy($request, $id);

        return $data;
    }
}
