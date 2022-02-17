<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\WarehouseDataService;
use App\Http\Requests\CreateWarehouseData;
use App\Http\Requests\UpdateWarehouseData;

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
            $data['title'] = 'Warehouse Data';
            $data['menu'] = 'Warehouse Data';
            $data['subMenu'] = 'lists';

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
        $data['title'] = 'Warehouse Data';
        $data['menu'] = 'Warehouse Data';
        $data['subMenu'] = 'add';

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
     * @param  UpdateWarehouseData $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateWarehouseData $request, $id)
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
