<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FbaList;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFbaList;
use App\Http\Requests\UpdateFbaList;
use App\Application\Services\FbaListService;


class FbaListController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        FbaListService $service
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
            $data['title'] = trans('messages.fba');
            $data['menu'] = trans('messages.fba');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.fba.index', $data);
        }

        $data = $this->service->datatable($request);

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $data = $this->service->create();
        $data['title'] = trans('messages.fba');
        $data['menu'] = trans('messages.fba');
        $data['subMenu'] = trans('actions.add');

        return view('admin.fba.add', $data);
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
     * @param CreateFbaList $request
     * @return Response
     */
    public function store(CreateFbaList $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.clients.index');
        }
        //dd('hello',$responseData);
        return $responseData;

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        $data['title'] = trans('messages.fba');
        $data['menu'] = trans('messages.fba');
        $data['subMenu'] = trans('actions.view');
        $data['fba'] = FbaList::find($id);
        //$data['fba']->load('fba_name', 'notes', 'label', 'address');

        return view('admin.fba.show', $data);
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
        
        $data['title'] = trans('messages.fba');
        $data['menu'] = trans('messages.fba');
        $data['subMenu'] = trans('actions.edit');
        $data['fba'] = FbaList::find($id);
        //dd($data['fba']->load('fba_name');
        //$data['fba']->load('fba_name', 'notes', 'label', 'address');

        return view('admin.fba.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFbaList $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateFbaList $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.fba.index');
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
