<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Application\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        CategoryService $service
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
