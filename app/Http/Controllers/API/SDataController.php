<?php

namespace App\Http\Controllers\API;

use App\Application\Services\SDataService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SDataController extends Controller
{
    /**
     * @var $service
     */
    protected $service;

    public function __construct( 
        SDataService $service
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
