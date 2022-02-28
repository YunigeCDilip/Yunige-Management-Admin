<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Services\UserService;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
     * @return View|Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()){
            $data['title'] = 'Users';
            $data['menu'] = 'Users';
            $data['subMenu'] = 'lists';

            return view('admin.users.index', $data);
        }

        $data = $this->service->datatable($request);

        return $data;
    }

    /**
     * Return data for view.
     *
     * @return View
     */
    public function create()
    {
        $data = $this->service->create();
        $data['title'] = 'Users';
        $data['menu'] = 'Users';
        $data['subMenu'] = 'add';

        return view('admin.users.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest $request
     * @return  Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = json_decode($this->service->store($request)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.users.index');
        }

        return $responseData;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        $data = $this->service->show($id);

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function edit($id)
    {
        $data = $this->service->create();
        $data['user'] = User::find($id);
        $data['permissionSelected'] = $data['user']->permissions()->pluck('id')->toArray();
        $data['title'] = 'Users';
        $data['menu'] = 'Users';
        $data['subMenu'] = 'edit';

        return view('admin.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  int $id
     * @return  Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = json_decode($this->service->update($request, $id)->getContent());
        $responseData['status'] = $data->status;
        $responseData['message'] = $data->message;
        if($data->status){
            $responseData['url'] = route('admin.users.index');
        }

        return $responseData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->service->destroy($request, $id);

        return $data;
    }
}
