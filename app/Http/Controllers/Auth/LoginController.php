<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/admin/dashboard';

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
        $input = $request->except('_token');

        if (\Auth::attempt($input)) {
            if (!\Auth::user()->is_verified && \Auth::user()->role === 'admin') {
                \Auth::logout();
                return redirect()->route('login')->with('message', 'danger=Your account is not verified, Please check your email');
            }
        } else {
            return back()->with('message', 'danger=Invalid Email or Password');
        }

        return redirect()->route('admin.dashboard');
    }
}
