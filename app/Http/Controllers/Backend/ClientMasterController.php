<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\ClientMasterService;
use App\Http\Requests\CreateClientMaster;
use App\Http\Requests\UpdateClientMaster;
use Throwable;

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
     * @param  CreateClientMaster $request
     * @return  Response
     */
    public function store(CreateClientMaster $request)
    {
        $data = $this->service->store($request);

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
     * @param  UpdateClientMaster $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateClientMaster $request, $id)
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
