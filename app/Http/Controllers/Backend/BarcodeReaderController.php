<?php

namespace App\Http\Controllers\Backend;

use PDF;
use Excel;
use Throwable;
use Illuminate\Http\Request;
use App\Models\ItemMasterStore;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorPNG;
use App\Exports\ReadableItemBarcodeExport;
use App\Application\Services\BarcodeReaderService;

class BarcodeReaderController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct(
        BarcodeReaderService $service
    ) {
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

    /**
     * export xlxs barcode items counts
     * @param Request $request
     * 
     * @return mixed
     */
    public function excel(Request $request)
    {
        try{
            $fileName = date('YmdHis') . 'items-read.xlsx';
            $file = Excel::download(new ReadableItemBarcodeExport($request), $fileName);

            return $file;

        }catch(Throwable $e){
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return redirect()->back();
        }
    }

    /**
     * export pdf barcode items counts
     * @param Request $request
     * 
     * @return mixed
     */
    public function pdf(Request $request)
    {
        try{
            $user = Auth::user();
            $logo = base64_encode(file_get_contents(public_path('/admin/images/logo-dark.png')));
            $items = ItemMasterStore::WithQuery()->whereIn('id', $request->ids)->get();
            $pdf = PDF::loadView('admin.barcode.pdf', compact('items', 'logo', 'user'));
            $pdf->setPaper('a4')->setOrientation('landscape')->setOption('images', true);
            $fileName = date('YmdHis') . 'items-read.pdf';
              
            return $pdf->download($fileName);  

        }catch(Throwable $e){
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return redirect()->back();
        }   
    }

    /**
     * generate barcode image
     * @param $barcode
     * 
     * @return mixed
     */
    public function generate($barcode)
    {
        try{
            $generator = new BarcodeGeneratorPNG();
            // file_put_contents('barcode.png', $generator->getBarcode('081231723897', BarcodeGenerator::TYPE_CODE_39, 1, 30));
            // echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, BarcodeGenerator::TYPE_CODE_39, 1, 80)) . '">';
            $bcode = base64_encode($generator->getBarcode($barcode, BarcodeGenerator::TYPE_CODE_39, 1, 50));

            $pdf = PDF::loadView('admin.barcode.barcode-pdf', compact('bcode', 'barcode'));
            $pdf->setOrientation('landscape')->setOption('images', true);
            $pdf->setOption('page-width', '29')->setOption('page-height', '42');
            $fileName = date('YmdHis') . 'barcode.pdf';

            // return view('admin.barcode.barcode-pdf', compact('bcode', 'barcode'));
              
            return $pdf->stream();  
            return $pdf->download($fileName);  
        }catch(Throwable $e){
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return redirect()->back();
        }   
    }
}
