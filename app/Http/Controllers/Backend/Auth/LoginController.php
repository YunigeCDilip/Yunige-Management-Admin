<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Models\User;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show login form
     * 
     * @return view
     */
    public function showLoginForm()
    {
         
        return view('front.auth.login');
    }

    /**
     * User Authentication
     * 
     * @param AuthRequest $request
     * 
     * @return
     */
    public function authenticate(AuthRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $rememberMe = $request->input('remember_me', 0);
        try {
            if($request->ajax()){
            	$user = User::where('email', $email)->first();
            	if($user->active_status){
            		if(Auth::attempt(['email' => $email, 'password' => $password], $rememberMe)) {
	                    $data['url'] = route('admin.dashboard');
	                    $data['status'] = 'true';
	                    $data['title'] = 'Sujal Dashboard';
	                    $data['message'] = 'Welcome To Admin Dashboard.';
	                    $request->session()->put(array(
	                        'title' => $data['title'],
	                        'success_message' => $data['message']
	                    ));
	                }else {
	                    $data['status'] = 'false';
	                    $data['message'] = 'Sorry ! Username or Password does not match.';
	                }
            	}else{
            		$data['status'] = 'false';
                    $data['message'] = 'Sorry ! Your account is disabled. please contact administrator.';
            	}
            }
        } catch (\Exception $e) {
            $data['status'] = 'false';
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    /**
     * Logout user sessions
     */
    public function logout()
    {
        if(Auth::check()){
            Auth::logout();
        }
        return redirect(route('login'));
    }
}
