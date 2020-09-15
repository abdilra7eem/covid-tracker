<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!Auth::user()){
            return redirect('/login');
        }
        
        $this->middleware('auth');
    }

    public function register()
    {
        return redirect('/')->withError("التسجيل مغلق. تواصل مع أحد المشرفين.");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        if(Auth::user()->account_type == 1){
            return redirect('/user');
        } elseif(Auth::user()->account_type == 2) {
            return redirect('/school');
        } elseif(Auth::user()->account_type == 3){
            return redirect('/incident');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function inactive(){
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == true){
            return redirect('/');
        }
        return view('inactive');
    }
}
