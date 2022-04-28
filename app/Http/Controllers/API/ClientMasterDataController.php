<?php

namespace App\Http\Controllers\API;

use App\Application\Services\ClientCategoryService;
use App\Application\Services\ShipperService;
use App\Http\Controllers\Controller;

class ClientMasterDataController extends Controller
{
    /**
     * @var ShipperService $shipperService
     * @var ClientCategoryService $categoryService
     */
    protected $shipperService;
    protected $categoryService;

    public function __construct( 
        ShipperService $shipperService,
        ClientCategoryService $categoryService
    )
    {
        $this->shipperService = $shipperService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function shippers()
    {
        $data = $this->shipperService->index();

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function categories()
    {
        $data = $this->categoryService->index();

        return $data;
    }
}
