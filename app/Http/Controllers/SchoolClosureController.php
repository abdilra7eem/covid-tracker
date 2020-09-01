<?php

namespace App\Http\Controllers;

use App\School;
use App\User;

use App\SchoolClosure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SchoolClosureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->account_type == 1) {
            $schoolclosures = User::where('users.account_type', 3)
                    ->join('school_closures', 'school_closures.user_id', 'users.id')
                    ->join('schools', 'schools.user_id', 'users.id')
                    ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 2) {
            $schoolclosures = User::where('directorate_id', Auth::user()->directorate_id)
                ->where('users.account_type', 3)
                ->join('school_closures', 'school_closures.user_id', 'users.id')
                ->join('schools', 'schools.user_id', 'users.id')
                ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 3) {
            $schoolclosures = User::where('id', Auth::user()->id)
                    ->join('school_closures', 'school_closures.user_id', 'users.id')
                    ->join('schools', 'schools.user_id', 'users.id')
                    ->inRandomOrder()->paginate(25);
        } else {
            abort(403, 'Unauthorized action.');
        }
        return view('schoolClosure.index')->withSchools($schoolClosure);
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
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolClosure $schoolClosure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolClosure $schoolClosure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolClosure $schoolClosure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolClosure $schoolClosure)
    {
        //
    }
}
