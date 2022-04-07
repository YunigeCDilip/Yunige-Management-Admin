<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\MovementConfirmationService;
use App\Http\Requests\CreateMovementConfirmation;
use App\Http\Requests\UpdateMovementConfirmation;

class MovementConfirmationController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        MovementConfirmationService $service
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
            $data['title'] = trans('messages.movement_confirmation');
            $data['menu'] = trans('messages.movement_confirmation');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.master.clients.movement.index', $data);
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
     * @param  CreateMovementConfirmation $request
     * @return  Response
     */
    public function store(CreateMovementConfirmation $request)
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
     * @param UpdateMovementConfirmation $request
     * @param $cat
     * @return Response
     */
    public function update(UpdateMovementConfirmation $request, $cat)
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
