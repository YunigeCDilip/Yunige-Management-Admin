<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Services\SettingService;

class SettingController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        SettingService $service
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
        $data['locales'] = $this->service->localization();
        $data['title'] = trans('menu.settings');
        $data['menu'] = trans('menu.settings');

        return view('admin.settings.index', $data);
    }  
    
    /**
     * update settings.
     * @param Request $request
     * 
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $this->service->update($request);
        
        return $data;
    }
}
