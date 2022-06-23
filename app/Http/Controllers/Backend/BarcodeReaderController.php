<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Services\BarcodeReaderService;

class BarcodeReaderController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct(
        BarcodeReaderService $service
    ){
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Response
     */
    public function index()
    {
        $data['title'] = trans('messages.barcode');
        $data['menu'] = trans('messages.barcode');
        $data['subMenu'] = trans('actions.reader');

        return view('admin.barcode.index', $data);
    }

    /**
     * list barcode items counts
     * @param Request $request
     * 
     * @return mixed
     */
    public function list(Request $request)
    {
        $data = $this->service->list($request);

        return $data;
    }

    /**
     * Check barcode items
     * @param Request $request
     * 
     * @return mixed
     */
    public function checkBarcode(Request $request)
    {
        $data = $this->service->checkBarcode($request);

        return $data;
    }
}
