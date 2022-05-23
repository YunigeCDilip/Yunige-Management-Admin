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
     * Store a newly created resource in storage.
     *
     * @param CreateFbaList $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.clients.index');
        }

        return $responseData;

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FbaList  $fbaList
     * @return \Illuminate\Http\Response
     */
    public function show(FbaList $fbaList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FbaList  $fbaList
     * @return \Illuminate\Http\Response
     */
    public function edit(FbaList $fbaList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FbaList  $fbaList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FbaList $fbaList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FbaList  $fbaList
     * @return \Illuminate\Http\Response
     */
    public function destroy(FbaList $fbaList)
    {
        //
    }
}
