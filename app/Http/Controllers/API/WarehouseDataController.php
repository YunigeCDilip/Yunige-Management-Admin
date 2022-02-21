<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWarehouseData;
use App\Http\Requests\UpdateWarehouseData;
use App\Application\Services\WarehouseDataService;

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
     * @return Response
     */
    public function index()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
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
