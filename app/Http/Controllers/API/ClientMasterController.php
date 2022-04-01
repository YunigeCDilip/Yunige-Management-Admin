<?php

namespace App\Http\Controllers\API;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Application\Services\ClientMasterService;

class ClientMasterController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ClientMasterService $service
    )
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function destory($id){
        $data = $this->service->destroy($id);
        return $data;
    }

    public function store(Request $request){
        $latestData = Client::withTrashed()->max('serial_number');
        // IF({ClientJP}="",{ClientEng},IF({ClientEng}="",{ClientJP},CONCATENATE(UPPER({ClientEng}),"-",{ClientJP})))
        // {ClientNameDisp}&"_"&{ClientNo}
        $clientDisplay = "";
        if($request->ja_name == "" && $request->en_name == "") $clientDisplay = "_".'c'.sprintf("%04s", $latestData+1);
        else if($request->ja_name == "") $clientDisplay = $request->en_name;
        else if($request->en_name == "") $clientDisplay = $request->ja_name;
        else $clientDisplay = $request->en_name."-".$request->ja_name."_".'c'.sprintf("%04s", $latestData+1);
        Log::info("Hello");
        $data = new Client();
        $data->ja_name = $request->ja_name;
        $data->en_name = $request->en_name;
        $data->serial_number = $latestData+1;
        $data->client_name = $clientDisplay;
        Log::info($data);
        $data->save();
        

    }
}
