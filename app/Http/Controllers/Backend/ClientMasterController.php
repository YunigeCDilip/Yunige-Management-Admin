<?php

namespace App\Http\Controllers\Backend;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClientMaster;
use App\Http\Requests\UpdateClientMaster;
use App\Application\Services\ClientMasterService;

class ClientMasterController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ClientMasterService $service
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
            $data['title'] = trans('messages.client');
            $data['menu'] = trans('messages.client');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.client.index', $data);
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
        $data['title'] = trans('messages.client');
        $data['menu'] = trans('messages.client');
        $data['subMenu'] = trans('actions.add');

        return view('admin.client.add', $data);
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
     * @param CreateClientMaster $request
     * @return Response
     */
    public function store(CreateClientMaster $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.clients.index');
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
        $data['title'] = trans('messages.client');
        $data['menu'] = trans('messages.client');
        $data['subMenu'] = trans('actions.view');
        $data['client'] = Client::find($id);
        $data['client']->load('contact', 'amazonProgress.progress', 'items', 'sdatas.sdata', 'wdatas', 'shipper', 'category', 'requestedClient', 'movement', 'classification', 'brands');

        return view('admin.client.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $data = $this->service->create();
        $data['title'] = trans('messages.client');
        $data['menu'] = trans('messages.client');
        $data['subMenu'] = trans('actions.edit');
        $data['client'] = Client::find($id);
        $data['client']->load('contact', 'amazonProgress', 'items', 'sdatas', 'wdatas', 'brands');

        return view('admin.client.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateClientMaster $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateClientMaster $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.clients.index');
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

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function deleteBrand(Request $request)
    {
        $data = $this->service->deleteBrand($request);

        return $data;
    }
}
