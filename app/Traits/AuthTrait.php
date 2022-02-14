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
}
