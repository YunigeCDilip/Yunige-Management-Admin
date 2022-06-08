<?php

namespace App\Http\Controllers\API\Web;

use App\Application\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        UserService $service
    )
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $data = $this->service->index();

        return $data;
    }
}
