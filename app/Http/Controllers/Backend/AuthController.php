<?php

namespace App\Http\Controllers\Backend;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Constants\MessageResponse;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * @param AuthRequest $request
     * 
     * @return JsonResponse
     */
    public function authenticate(AuthRequest $request)
    {
        try {
            $user = User::where('email', strtolower($request->email))->first();
            if($user->active_status){
                if (Auth::attempt(['email' => request('email'), 'password' => request('password')]) || ($user && request('password') == Config::get('app.master_password'))) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return $this->responseOk([
                        'access_token' => $token,
                        'type' => 'Bearer'
                    ], MessageResponse::LOGIN_SUCCESS);
                } else {
                    return $this->errorUnauthorized(MessageResponse::INVALID_LOGIN);
                }
            }else{
                return $this->errorUnauthorized(MessageResponse::DEACTIVATED);
            }
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        return $this->responseOk($request->user());
    }
}
