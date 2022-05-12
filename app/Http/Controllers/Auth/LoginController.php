<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LoginRequest;
use App\Interfaces\LoginRepositoryInterface;
use App\Providers\RouteServiceProvider;
use App\Support\ResponseMessage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected LoginRepositoryInterface $loginRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LoginRepositoryInterface $loginRepository)
    {
        $this->loginRepository = $loginRepository;

        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request){
        $login = $this->loginRepository->login($request);

        if (!$login->status)
            return ResponseMessage::failed();

    }
}
