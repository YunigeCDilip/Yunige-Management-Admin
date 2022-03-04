<?php

namespace App\Http\Controllers\Backend;

use App\Traits\BreadCrumbs;
use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;

class DashboardController extends Controller
{
    use AuthTrait, BreadCrumbs;
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$data['menu'] = trans('menu.dashboard');
        $data['title'] = trans('menu.yunige_service');

    	return view('admin.dashboard', $data);
    }
}
