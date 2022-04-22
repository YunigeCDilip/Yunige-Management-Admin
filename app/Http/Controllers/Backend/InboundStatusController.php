<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\InboundStatusService;
use App\Http\Requests\CreateInboundStatus;
use App\Http\Requests\UpdateInbounStatus;

class InboundStatusController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        InboundStatusService $service
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
            $data['title'] = trans('messages.wdata_inbounds');
            $data['menu'] = trans('messages.wdata_inbounds');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.wdata.inbound.index', $data);
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
     * @param CreateInboundStatus $request
     * @return Response
     */
    public function store(CreateInboundStatus $request)
    {
        $data = $this->service->store($request);

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param $cat
     * @return Response
     */
    public function show($cat)
    {
        $data = $this->service->show($cat);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInbounStatus $request
     * @param $cat
     * @return Response
     */
    public function update(UpdateInbounStatus $request, $cat)
    {
        $data = $this->service->update($request, $cat);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cat
     * @return Response
     */
    public function destroy(Request $request, $cat)
    {
        $data = $this->service->destroy($request, $cat);

        return $data;
    }
}
