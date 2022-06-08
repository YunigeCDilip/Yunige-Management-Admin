<?php

namespace App\Application\Services;

use Throwable;
use App\Models\User;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use App\Application\Services\RoleService;
use App\Application\Contracts\UserContract;

class UserService extends Service
{
    /**
     *
     * @var User $contract
     * @var RoleService $roleService
    */
    protected $contract;

    public function __construct(
        UserContract $contract,
        RoleService $roleService
    ){
        $this->contract = $contract;
        $this->roleService = $roleService;
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function index(){
        try {
            $data = $this->contract->index();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * return all datatable resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatable($request)
    {
        try {
            $columns = array(
                0 => 'id',
                1 => 'name',
                2 => 'email',
                3 => 'role',
                4 => 'active_status',
                5 => 'created_at',
                6 => 'id',
            );
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $dat = array();
            $datas = array();
            if (empty($request->input('search.value'))) {
                for ($i = 1; $i < count($request->columns); $i++) {
                    if (isset($request->columns[$i]['search']['value'])) {
                        $dat[$request->columns[$i]['data']] = $request->columns[$i]['search']['value'];
                    }
                    $datas = $dat;
                }

                if (!empty($datas)) {
                        $userLists = User::select('*');
                        $userListss = $userLists->FilterSuperAdmin()
                        ->FilteredByName((isset($datas['name']) && $datas['name'] != "") ? $datas['name'] : '')
                        ->FilteredByEmail((isset($datas['email']) && $datas['email'] != "") ? $datas['email'] : '')
                        ->FilteredByActiveStatus((isset($datas['active_status']) && $datas['active_status'] != "") ? $datas['active_status'] : '')
                        ->FilteredByCreatedDate((isset($datas['created_at']) && $datas['created_at'] != "") ? $datas['created_at'] : '', $request->date)
                        ->FilterByDateRange((isset($datas['created_at']) && $datas['created_at'] != "") ? $datas['created_at'] : '', $request->date);
                    $totalUsersCount = $userLists->count();
                    $users = $userListss->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalUsersCount;

                } else {
                    $userLists = User::select('*')->FilterSuperAdmin();
                    $totalUsersCount = $userLists->count();
                    $users = $userLists->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->get();
                    $totalFiltered = $totalUsersCount;

                }

            } else {

                $searchKey = $request->input('search.value');
                $userLists = User::select('*')
                    ->FilterSuperAdmin()->FilterByGlobalSearch($searchKey);
                $totalUsersCount = $userLists->count();
                $users = $userLists->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $totalUsersCount;

            }
            $tableContent = array();
            if (!empty($users)) {
                $userData = array();
                foreach ($users as $index => $user) {
                    $nestedData = array();
                    $nestedData['id'] = $index + 1;
                    $nestedData['userId'] = $user->id;
                    $nestedData['name'] = $user->name;
                    $nestedData['role'] = (!$user->roles->isEmpty()) ? $user->roles[0]->name : 'Super Admin';
                    $nestedData['email'] = $user->email;
                    $nestedData['active_status'] = $user->active_status;
                    $nestedData['created_at'] = $user->created_at->toDateTimeString();
                    $nestedData['manage_permission'] = $this->checkPermission('manage.user');
                    $nestedData['is_auth_user'] = ($user->id == $this->getAuthUser()->id) ? true : false;
                    $userData[] = $nestedData;
                }

                $tableContent = array(
                    "draw" => intval($request->input('draw')),
                    "recordsTotal" => $totalUsersCount,
                    "recordsFiltered" => $totalFiltered,
                    "data" => $userData,
                );
            }
            return $tableContent;
            
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Return all active data for view.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $roles = json_decode($this->roleService->all()->getContent());
            $permissions = json_decode($this->roleService->permissions()->getContent());
            $data['roles'] = $roles->payload;
            $data['permissions'] = $permissions->payload;

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => bcrypt($request->password),
                'active_status' => $request->status,
            ])->syncRoles([$request->role])->syncPermissions($request->permissions);

            return $this->responseOk($user, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Show the form for showing the specified resource.
     *
     * @param  int $id
     * @return  Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            return $this->responseOk($user, MessageResponse::DATA_LOADED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return  Response
     */
    public function update($request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->active_status = $request->status;
            $user->password = ($request->has('password')) ? bcrypt($request->password) : $user->password;
            $user->save();

            $user->syncRoles([$request->role])->syncPermissions($request->permissions);

            return $this->responseOk($user, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return  Response
     */
    public function destroy($request, $id)
    {
        try {
            $data = User::find($id);
            if($data->roles()){
                $data->syncRoles([]);
            }
            
            if($data->permissions()){
                $data->syncPermissions([]);
            }

            $data->delete();

            return $this->responseOk(null, MessageResponse::DATA_DELETED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * activate/deactivate users
     *
     * @param  int $id
     * @return  Response
     */
    public function activate($request)
    {
        try {
            $user = User::find($request->id);
            $user->active_status = $request->status;
            $user->save();

            return $this->responseOk([], MessageResponse::DATA_UPDATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }
    /**
     * login users user profile
     *
     * 
     * @return  Response
     */
    public function userProfile()
    {
        $user = $this->getAuthUser();

        return $this->responseOk($user, MessageResponse::DATA_LOADED);
    }
    /**
     * update users user profile
     * @param  Request $request
     * @param  int $id
     * @return  Response
     */
    public function userProfileUpdate($request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            //$user->active_status = $request->status;
            //$user->password = ($request->has('password')) ? bcrypt($request->password) : $user->password;
            $user->save();

            //$user->syncRoles([$request->role])->syncPermissions($request->permissions);

            return $this->responseOk($user, MessageResponse::DATA_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }

    }
}
