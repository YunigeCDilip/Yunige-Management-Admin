<?php

namespace App\Http\Controllers\Backend;

use App\Models\CustomBroker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomBroker;
use App\Http\Requests\UpdateCustomBroker;
use App\Application\Services\CustomBrokerService;

class CustomBrokerController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        CustomBrokerService $service
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
        if(!$request->ajax()){
            $data['title'] = trans('messages.custom_brokers');
            $data['menu'] = trans('messages.custom_brokers');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.wdata.broker.index', $data);
        }

        $data = $this->service->datatable($request);

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
        $data['title'] = trans('messages.custom_brokers');
        $data['menu'] = trans('messages.custom_brokers');
        $data['subMenu'] = trans('actions.add');

        return view('admin.master.wdata.broker.add', $data);
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
     * @param CreateCustomBroker $request
     * @return Response
     */
    public function store(CreateCustomBroker $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.custom-brokers.index');
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
        $data['title'] = trans('messages.custom_brokers');
        $data['menu'] = trans('messages.custom_brokers');
        $data['subMenu'] = trans('actions.view');
        $data['broker'] = CustomBroker::find($id);
        $data['broker']->load('wdatas.wdata');

        return view('admin.master.wdata.broker.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $broker = CustomBroker::find($id);
        if(!$broker){
            return redirect()->back();
        }
        $data['title'] = trans('messages.custom_brokers');
        $data['menu'] = trans('messages.custom_brokers');
        $data['subMenu'] = trans('actions.edit');
        $data['broker'] = $broker;

        return view('admin.master.wdata.broker.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomBroker $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCustomBroker $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.custom-brokers.index');
        }

        return $responseData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->service->destroy($request, $id);

        return $data;
    }
}
