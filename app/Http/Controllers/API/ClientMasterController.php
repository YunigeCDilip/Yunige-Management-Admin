<?php

namespace App\Http\Controllers\API;

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
     * @return Response
     */
    public function index()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Add new item to storage
     * 
     * @param CreateClientMaster $request
     * 
     * @return Response
     */
    public function store(CreateClientMaster $request)
    {
        $data = $this->service->store($request);
        
        return $data;
    }

    /**
     * Show item from storage
     * 
     * @param mixed $id
     * 
     * @return Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }

    /**
     * Update item from storage
     * 
     * @param UpdateClientMaster $request
     * @param int $id
     * 
     * @return Response
     */
    public function update(UpdateClientMaster $request, $id)
    {
        $data = $this->service->update($request, $id);

        return $data;
    }

    /**
     * Delete item from storage
     * 
     * @param mixed $id
     * 
     * @return Response
     */
    public function destory($id)
    {
        $data = $this->service->destroy($id);

        return $data;
    }
}
