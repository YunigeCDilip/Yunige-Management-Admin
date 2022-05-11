<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\ItemLabelService;
use App\Http\Requests\CreateItemLabel;
use App\Http\Requests\UpdateItemLabel;

class ItemLabelController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ItemLabelService $service
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
            $data['title'] = trans('messages.item_labels');
            $data['menu'] = trans('messages.item_labels');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.item.label.index', $data);
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
     * @param CreateItemLabel $request
     * @return Response
     */
    public function store(CreateItemLabel $request)
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
     * @param UpdateItemLabel $request
     * @param $cat
     * @return Response
     */
    public function update(UpdateItemLabel $request, $cat)
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
