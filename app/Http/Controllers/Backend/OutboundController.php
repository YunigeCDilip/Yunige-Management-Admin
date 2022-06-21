<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\OutboundService;
use App\Models\Outbound;

class OutboundController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        OutboundService $service
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
            $data['title'] = trans('messages.outbounds');
            $data['menu'] = trans('messages.outbounds');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.outbound.index', $data);
        }

        $data = $this->service->datatable($request);

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
        $data['title'] = trans('messages.outbounds');
        $data['menu'] = trans('messages.outbounds');
        $data['subMenu'] = trans('actions.view');
        $data['outbound'] = Outbound::find($id);
        $data['outbound']->load('fbalists', 'wdata:id,name','delivery:id,name');
        $data['warehouseIncharge'] = json_decode(json_encode($data['outbound']->warehouse_in_charge), true);
        $data['attachments'] = $data['outbound']->groupedAttachments();

        return view('admin.outbound.show', $data);
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
