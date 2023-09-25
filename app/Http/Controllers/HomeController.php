<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        if($user->role==1) {
            return redirect()->route('admin.dashboard');
        }

        if($user->role==2 || $user->role==3){
            return redirect()->route('staff.dashboard');
        }
    }

}
