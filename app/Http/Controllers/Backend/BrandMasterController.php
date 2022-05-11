<?php

namespace App\Http\Controllers\Backend;

use App\Models\BrandMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandMaster;
use App\Http\Requests\UpdateBrandMaster;
use App\Application\Services\BrandMasterService;

class BrandMasterController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        BrandMasterService $service
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
            $data['title'] = trans('messages.brand_masters');
            $data['menu'] = trans('messages.brand_masters');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.item.brands.index', $data);
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
        $data['title'] = trans('messages.brand_masters');
        $data['menu'] = trans('messages.brand_masters');
        $data['subMenu'] = trans('actions.add');

        return view('admin.master.item.brands.add', $data);
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
     * @param CreateBrandMaster $request
     * @return Response
     */
    public function store(CreateBrandMaster $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.item-brands.index');
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
        $data['title'] = trans('messages.brand_masters');
        $data['menu'] = trans('messages.brand_masters');
        $data['subMenu'] = trans('actions.view');
        $data['brand'] = BrandMaster::find($id);
        $data['brand']->load('country');

        return view('admin.master.item.brands.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $brand = BrandMaster::find($id);
        if(!$brand){
            return redirect()->back();
        }
        $data = $this->service->create();
        $data['title'] = trans('messages.brand_masters');
        $data['menu'] = trans('messages.brand_masters');
        $data['subMenu'] = trans('actions.edit');
        $data['brand'] = $brand;

        return view('admin.master.item.brands.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandMaster $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateBrandMaster $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.item-brands.index');
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
