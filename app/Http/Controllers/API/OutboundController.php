<?php

namespace App\Http\Controllers\API;

use App\Application\Services\OutboundService;
use App\Http\Controllers\Controller;

class OutboundController extends Controller
{
    /**
     * @var $service
     */
    protected $service;

    public function __construct( 
        OutboundService $service
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
     * Show the form for showing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }
}
