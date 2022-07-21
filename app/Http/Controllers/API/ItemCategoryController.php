<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\ItemCategoryService;


class ItemCategoryController extends Controller
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        ItemCategoryService $service
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
