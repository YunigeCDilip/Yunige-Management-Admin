<?php

namespace App\Http\Controllers\API;

use App\Application\Services\ClientMasterService;
use App\Http\Controllers\Controller;

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
}
