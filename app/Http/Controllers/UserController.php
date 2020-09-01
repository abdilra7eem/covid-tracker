<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $type = 'all';
        if($request->input('type') == 'admins'){
            $type = 'admins';
        } elseif($request->input('type') == 'supervisors'){
            $type = 'supervisors';
        }

        if(Auth::user()->account_type == 1) {
            if($type == 'admins'){
                $users = User::where('account_type', 1)
                ->paginate(25);
            } elseif($type == 'supervisors') {
                $users = User::where('account_type', 2)
                ->paginate(25);
            } else {
                $users = User::where('account_type', '!=', 3)
                ->paginate(25);
            }
            return view('user.index')->withUsers($users);
        } elseif(Auth::user()->account_type == 2){
            if($type == 'admins'){
                $users = User::where('account_type', 1)
                    ->paginate(25);
            } elseif($type == 'supervisors') {
                $users = User::where('account_type', 2)
                ->where('directorate_id', Auth::user()->directorate_id)
                ->paginate(25);
            } else {
                $users = User::where('account_type', '!=', 3)
                ->where('directorate_id', Auth::user()->directorate_id)
                ->orWhere('account_type', 1)
                ->orderBy('account_type', 'DESC')
                ->paginate(25);
            }
            return view('user.index')->withUsers($users);
        } elseif(Auth::user()->account_type == 3) {
            $users = User::where('account_type', 2)
                ->where('directorate_id', Auth::user()->directorate_id)
                ->paginate(25);
            return view('user.index')->withUsers($users);
        }
        abort(403, 'Unauthorized action.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
