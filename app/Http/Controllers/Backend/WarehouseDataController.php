<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Domains\WarehouseDomain;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWarehouseData;
use App\Http\Requests\UpdateWarehouseData;
use App\Application\Services\WarehouseDataService;
use App\Http\Requests\CreateClientMaster;
use App\Http\Requests\CreateItemMaster;

class WarehouseDataController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        WarehouseDataService $service
    )
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()){
            $data['title'] = trans('messages.warehouse_data');
            $data['menu'] = trans('messages.warehouse_data');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.warehouse.data.index', $data);
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
        $data['title'] = trans('messages.warehouse_data');
        $data['menu'] = trans('messages.warehouse_data');
        $data['subMenu'] = trans('actions.add');

        return view('admin.warehouse.data.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWarehouseData $request
     * @return  Response
     */
    public function store(CreateWarehouseData $request)
    {

        dd($request->all());
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.wdata.index');
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
        $data['title'] = trans('messages.warehouse_data');
        $data['menu'] = trans('messages.warehouse_data');
        $data['subMenu'] = trans('actions.view');
        $wdata = json_decode($this->service->show($id)->getContent());
        $data['wdata'] = $wdata->payload;

        return view('admin.warehouse.data.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        $data = $this->service->create();
        $wdata = json_decode($this->service->show($id)->getContent());
        $data['title'] = trans('messages.warehouse_data');
        $data['menu'] = trans('messages.warehouse_data');
        $data['subMenu'] = trans('actions.edit');
        $data['wdata'] = $wdata->payload;

        return view('admin.warehouse.data.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateWarehouseData $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateWarehouseData $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.wdata.index');
        }

        return $responseData;
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

    /**
     * Save client on Wdata form
     *
     * @param CreateClientMaster $request
     * @return Response
     */
    public function saveClient(CreateClientMaster $request)
    {
        $data = $this->service->saveClient($request);

        return $data;
    }

    /**
     * Save item on Wdata form
     *
     * @param CreateItemMaster $request
     * @return Response
     */
    public function saveItem(CreateItemMaster $request)
    {
        $data = $this->service->saveItem($request);

        return $data;
    }
}
