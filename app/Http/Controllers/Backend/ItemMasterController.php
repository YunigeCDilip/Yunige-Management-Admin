<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\ItemMasterService;
use App\Http\Requests\CreateItemMaster;
use App\Http\Requests\UpdateItemMaster;
use App\Models\ItemMaster;

class ItemMasterController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ItemMasterService $service
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
            $data['title'] = trans('messages.item');
            $data['menu'] = trans('messages.item');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.item.index', $data);
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
        $data['title'] = trans('messages.item');
        $data['menu'] = trans('messages.item');
        $data['subMenu'] = trans('actions.add');

        return view('admin.item.add', $data);
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
     * @param CreateItemMaster $request
     * @return Response
     */
    public function store(CreateItemMaster $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.items.index');
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
        $data['title'] = trans('messages.item');
        $data['menu'] = trans('messages.item');
        $data['subMenu'] = trans('actions.view');
        $data['item'] = ItemMaster::find($id);
        $data['item']->load('category', 'shipper', 'label', 'clientItems', 'brands', 'productTypes.type', 'images');

        return view('admin.item.show', $data);
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
        $data['title'] = trans('messages.item');
        $data['menu'] = trans('messages.item');
        $data['subMenu'] = trans('actions.edit');
        $data['item'] = ItemMaster::find($id);
        $data['item']->load('category', 'shipper', 'label', 'clientItems', 'brands', 'productTypes.type', 'images','pdf');

        return view('admin.item.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateItemMaster $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateItemMaster $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.items.index');
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
}
