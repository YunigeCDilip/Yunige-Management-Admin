<?php

namespace App\Http\Controllers\Backend;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Application\Services\RoleService;

class RoleController extends Controller 
{
    /**
     * @var  $service
     */
    protected $service;

    public function __construct( 
        RoleService $service
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
        $data['title'] = 'Role Management';
        $data['menu'] = 'User Management';
        $data['subMenu'] = 'Roles';
        $data['roles'] = Role::orderBy('id', 'desc')->paginate(6);

        return view('admin.users.roles.index', $data);
    }

    /**
     * Return all permissions
     *
     * @return Response
     */
    public function permissions()
    {
        $data = $this->service->permissions();

        return $data;
    }

    /**
     * Return all active data for view.
     *
     * @return Response
     */
    public function all()
    {
        $data = $this->service->all();

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRoleRequest $request
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $data = $this->service->store($request);

        return $data;
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param Role $role
     * @return  Response
     */
    public function show(Role $role)
    {
        $data = $this->service->show($role);

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $data = $this->service->edit($role);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $this->service->update($request, $role);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy(Request $request, Role $role)
    {
        $data = $this->service->destroy($request, $role);

        return $data;
    }
}
