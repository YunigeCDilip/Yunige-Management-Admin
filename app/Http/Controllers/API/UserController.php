<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Application\Services\UserService;
use App\Models\User;


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
     * @return Response
     */
    public function index()
    {
        $data = $this->service->index();

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
      * @param CreateUserRequest $request
     * 
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $this->service->store($request);
        
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $id
     * 
     * @return Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
      * @param UpdateUserRequest $request
     * @param int $id
     * 
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $this->service->update($request, $id);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * 
     * @return Response
     */
    public function destroy($id)
    {
        $data = $this->service->destroy($id);

        return $data;
    }
    /**
     * show login user profile
     * @return [type]
     */
    public function userProfile()
    {
        $data = $this->service->userProfile();

        return $data;
    }
    /**
     * update user profile
     * @return [type]
     */
    public function updateProfile(UpdateUserProfileRequest $request, $id)
    {
        $data = $this->service->userProfileUpdate($request, $id);

        return $data;
    }
        
    
}
