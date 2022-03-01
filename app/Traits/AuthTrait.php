<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    /**
     * @param
     *
     * @return data of user resource
     */
    public function getAuthUser()
    {
        $user = Auth::user();

        return $user;
    }
    

    /**
     * @param mixed $permission
     * 
     * @return bool
     */
    public function checkPermission($permission){
        $user = Auth::user();
        if($user->is_super_admin){
            return true;
        }else{
            if($user->hasPermissionTo($permission)){
                return true;
            }else{
                return false;
            }
        }
    }
}
