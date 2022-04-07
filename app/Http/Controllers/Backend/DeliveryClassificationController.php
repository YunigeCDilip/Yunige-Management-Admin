<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Application\Services\DeliveryClassificationService;
use App\Http\Requests\CreateDeliveryClassification;
use App\Http\Requests\UpdateDeliveryClassification;
use Throwable;

class DeliveryClassificationController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        DeliveryClassificationService $service
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
            $data['title'] = trans('messages.delivery_classification');
            $data['menu'] = trans('messages.delivery_classification');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.clients.classification.index', $data);
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
     * @param  CreateDeliveryClassification $request
     * @return  Response
     */
    public function store(CreateDeliveryClassification $request)
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
     * @param UpdateDeliveryClassification $request
     * @param $cat
     * @return Response
     */
    public function update(UpdateDeliveryClassification $request, $cat)
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

    /**
     * activate/deactivate categories
     *
     * @param  int $id
     * @return  Response
     */
    public function activate(Request $request)
    {
        $data = $this->service->activate($request);

        return $data;
    }
}
