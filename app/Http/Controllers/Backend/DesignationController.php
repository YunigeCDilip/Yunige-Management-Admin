<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Requests\CreateDesignation;
use App\Http\Requests\UpdateDesignation;
use App\Application\Services\DesignationService;

class DesignationController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        DesignationService $service
    )
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     *  @return View|Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()){
            $data['title'] = trans('messages.designation');
            $data['menu'] = trans('messages.designation');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.designations.index', $data);
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
     * @param  CreateDesignation $request
     * @return  Response
     */
    public function store(CreateDesignation $request)
    {
        $data = $this->service->store($request);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param Designation $Designation
     * @return Response
     */
    public function show(Designation $Designation)
    {
        $data = $this->service->show($Designation);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDesignation $request
     * @param Designation $Designation
     * @return Response
     */
    public function update(UpdateDesignation $request, Designation $Designation)
    {
        $data = $this->service->update($request, $Designation);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Designation $Designation
     * @return Response
     */
    public function destroy(Request $request, Designation $Designation)
    {
        $data = $this->service->destroy($request, $Designation);

        return $data;
    }
}
