<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\AmazonProgressService;
use App\Http\Requests\CreateAmazonProgress;
use App\Http\Requests\UpdateAmazonProgress;
use App\Models\AmazonProgress;

class AmazonProgressController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        AmazonProgressService $service
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
            $data['title'] = trans('messages.amazon_progress');
            $data['menu'] = trans('messages.amazon_progress');
            $data['subMenu'] = trans('actions.lists');

            return view('admin.amazon-progress.index', $data);
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
        $data['title'] = trans('messages.amazon_progress');
        $data['menu'] = trans('messages.amazon_progress');
        $data['subMenu'] = trans('actions.add');

        return view('admin.amazon-progress.add', $data);
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
     * @param CreateAmazonProgress $request
     * @return Response
     */
    public function store(CreateAmazonProgress $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.amazon-progress.index');
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
        $data['title'] = trans('messages.amazon_progress');
        $data['menu'] = trans('messages.amazon_progress');
        $data['subMenu'] = trans('actions.view');
        $data['client'] = AmazonProgress::find($id);
        $data['client']->load('contact', 'amazonProgress.progress', 'items', 'sdatas.sdata', 'wdatas', 'shipper', 'category', 'requestedClient', 'movement', 'classification', 'brands');

        return view('admin.amazon-progress.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $amazon = AmazonProgress::find($id);
        if(!$amazon){
            return redirect()->back();
        }
        $amazon->load('amazonProgress', 'files');

        $data = $this->service->create();
        $data['title'] = trans('messages.amazon_progress');
        $data['menu'] = trans('messages.amazon_progress');
        $data['subMenu'] = trans('actions.edit');
        $data['amazon'] = $amazon;

        return view('admin.amazon-progress.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAmazonProgress $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateAmazonProgress $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.amazon-progress.index');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function deleteFile($id)
    {
        $data = $this->service->deleteFile($id);

        return $data;
    }
}
