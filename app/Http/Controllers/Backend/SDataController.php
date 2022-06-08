<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Application\Services\SDataService;
use App\Http\Requests\CreateSDataRequest;
use App\Http\Requests\UpdateSDataRequest;
use Throwable;

class SDataController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        SDataService $service
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
        $data = $this->service->index();

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
     * @param  CreateSDataRequest $request
     * @return  Response
     */
    public function store(CreateSDataRequest $request)
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
     * @param  UpdateSDataRequest $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateSDataRequest $request, $id)
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
