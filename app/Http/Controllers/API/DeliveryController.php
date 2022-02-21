<?php

namespace App\Http\Controllers\API;

use App\Application\Services\DeliveryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        DeliveryService $service
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
