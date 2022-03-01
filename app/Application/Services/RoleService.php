<?php

namespace App\Application\Services;

use Throwable;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Response;
use App\Constants\MessageResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\RoleResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\DatabaseManager;

class RoleService extends Service
{
    /**
     *
     * @var DatabaseManager $db
    */
    protected $db;

    public function __construct(
        DatabaseManager $db
    ){
        $this->db = $db;
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index()
    {
        try {
            $data = QueryBuilder::for(Role::class)
                ->defaultSort('name')
                ->allowedSorts('id', 'name')
                ->allowedFilters(['name', AllowedFilter::scope('search')])
                ->paginate((request('per_page')) ?? 10);

            return $this->responsePaginate(RoleResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function permissions()
    {
        try {
            $data = Permission::grouped('web');

            return $this->responseOk($data, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return all active data for view.
     *
     * @return  Response
     */
    public function all()
    {
        try {
            $data = Role::orderBy('name')->get();

            return $this->responseOk(RoleResource::collection($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    Request  $request
     * @return  Response
     */
    public function store($request)
    {
        try {
            $this->db->beginTransaction();
            $data = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web'
            ]);

            $this->db->commit();

            return $this->responseOk(new RoleResource($data), MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param Role $role
     * @return  Response
     */
    public function show(Role $role)
    {
        try {
            $data = Role::find($role->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new RoleResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return  Response
     */
    public function edit(Role $role)
    {
        try {
            $data = Role::find($role->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            return $this->responseOk(new RoleResource($data), MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  Role $role
     * @return  Response
     */
    public function update($request, Role $role)
    {
        try {
            $this->db->beginTransaction();
            $data = Role::find($role->id);
            if(!$data){
                return $this->responseError(Response::HTTP_NOT_FOUND, MessageResponse::NOT_FOUND);
            }

            $data->name = $request->name;
            $data->save();

            $this->db->commit();

            return $this->responseOk(new RoleResource($data), MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Role $role
     * @return  Response
     */
    public function destroy($request, Role $role)
    {
        try {
            $role = Role::find($role->id);
            $isRoleUsed = User::whereHas('roles', function($query) use($role) {
                $query->where('id', $role->id);
            })->count();
            if($isRoleUsed > 0){
                return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, MessageResponse::NOT_DELETED);
            }
            $role->syncPermissions();
            $role->delete();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            $this->db->rollback();
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
}
