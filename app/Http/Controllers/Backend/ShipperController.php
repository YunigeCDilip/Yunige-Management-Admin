<?php

namespace App\Http\Controllers\Backend;

use App\Models\Shipper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShipper;
use App\Http\Requests\UpdateShipper;
use App\Application\Services\ShipperService;

class ShipperController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ShipperService $service
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
            $data['title'] = trans('messages.shippers');
            $data['menu'] = trans('messages.shippers');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.clients.shipper.index', $data);
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
     * @param  CreateShipper $request
     * @return  Response
     */
    public function store(CreateShipper $request)
    {
        $data = $this->service->store($request);

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param Shipper $shipper
     * @return Response
     */
    public function show(Shipper $shipper)
    {
        $data = $this->service->show($shipper);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShipper $request
     * @param Shipper $shipper
     * @return Response
     */
    public function update(UpdateShipper $request, Shipper $shipper)
    {
        $data = $this->service->update($request, $shipper);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shipper $shipper
     * @return Response
     */
    public function destroy(Request $request, Shipper $shipper)
    {
        $data = $this->service->destroy($request, $shipper);

        return $data;
    }
}