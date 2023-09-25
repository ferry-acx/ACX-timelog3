<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    protected function login( Request $request ){
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            $user=Auth::user()->role;
            if(!Auth::check()) {
                return redirect('/login');
            }

            switch($user){
                case 1:
                    return redirect()->route('admin.dashboard');
                    break;
                case 2:
                    return redirect()->route('staff.dashboard');
                    break;
                case 3:
                    return redirect()->route('staff.dashboard');
                    break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('error','something went wrong');
            }

        } else {
            return redirect('/login')->with('error', 'Incorrect credentials');
        }
    }
}
