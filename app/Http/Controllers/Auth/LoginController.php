<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

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

    use AuthenticatesUsers;

    const MAX_LOGIN_ATTEMPTS = 3;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
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
     * Get the needed authorization credentials from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = ['password'=>$request->get('password')];
        if(is_numeric($request->get('email')))
            $credentials['phone'] = $request->get('email');
        else
            $credentials['email'] = $request->get('email');
        return $credentials;
    }
    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @return void
     *
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);
    }
    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return void
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        Session::put('counter', Cache::get($this->throttleKey($request)));
        
        $arr = [];
        if (\session('counter') >= static::MAX_LOGIN_ATTEMPTS){
            $arr['rechapcha'] = 'Show rechapcha';
        }
        throw ValidationException::withMessages(
            array_merge($arr, [$this->username() => [trans('auth.failed')]])
        );
    }
    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param  mixed  $user
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        $userRole = $user->roles->pluck('name')->first();
        if ($userRole == "Admin"){
            session('admin');
            $this->redirectTo = '/dashboard';
        }else{
            $this->redirectTo = '/';
        }
    }

}
