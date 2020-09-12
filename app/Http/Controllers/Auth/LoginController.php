<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Hash;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
  {
    $this->validateLogin($request);
    if ($this->attemptLogin($request)) {
      return $this->sendLoginResponse($request);
    }
    return $this->sendFailedLoginResponse($request);
  }
  protected function credentials(Request $request)
  {
    $user = User::where('username',$request->get($this->username()))->first();

    $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
    ? $this->username()
    : 'username';

    if ($user === null) {
      return ['username'=>'inactive','password'=>'Anda tidak memiliki akses pada aplikasi ini.'];
    }
    if ($user->status == 0) {
      return ['username'=>'inactive','password'=>'Akun anda tidak aktif, silakan hubungi  Admin'];
    }else {
      return [
      $field => $request->get($this->username()),
      'password' => $request->password,
      'status'=> 1,
      ];
    }
  }
}
