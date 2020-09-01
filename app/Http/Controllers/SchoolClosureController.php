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
        $type = "all";
        if (Auth::user()->account_type == 1) {
            if($request->input('type') == 'complete'){
                $schools = SchoolClosure::where('grade', '>', 12)
                    ->where('reopening_date', null)
                    // ->where('school_closures.user_id', 98)
                    ->inRandomOrder()
                    ->orderBy('grade', 'DESC')
                    ->join('users', 'school_closures.user_id', 'users.id')
                    ->join('schools', 'school_closures.user_id', 'schools.user_id')
                    ->get()->unique('user_id');
                $type = 'complete';
            } else {
                $schools = SchoolClosure::where('reopening_date', null)
                    // ->where('school_closures.user_id', 98)
                    ->inRandomOrder()
                    ->orderBy('grade', 'DESC')
                    ->join('users', 'school_closures.user_id', 'users.id')
                    ->join('schools', 'school_closures.user_id', 'schools.user_id')
                    ->get()->unique('user_id');
                    // ->where('grade', '<', 13);
                if($request->input('type') == 'partial') {
                    $type = 'partial';
                }
            }
        } elseif(Auth::user()->account_type == 2) {
            if($request->input('type') == 'complete'){
                $schools = SchoolClosure::where('grade', '>', 12)
                    ->where('reopening_date', null)
                    // ->where('school_closures.user_id', 98)
                    ->inRandomOrder()
                    ->orderBy('grade', 'DESC')
                    ->join('users', 'school_closures.user_id', 'users.id')
                    ->where('users.directorate_id', Auth::user()->directorate_id)
                    ->join('schools', 'school_closures.user_id', 'schools.user_id')
                    ->get()->unique('user_id');
                $type = 'complete';
            } else {
                $schools = SchoolClosure::where('reopening_date', null)
                    // ->where('school_closures.user_id', 98)
                    ->inRandomOrder()
                    ->join('users', 'school_closures.user_id', 'users.id')
                    ->where('users.directorate_id', Auth::user()->directorate_id)
                    ->orderBy('school_closures.grade', 'DESC')
                    ->join('schools', 'school_closures.user_id', 'schools.user_id')
                    ->get()->unique('user_id');
                    // ->where('grade', '<', 13);
                if($request->input('type') == 'partial') {
                    $type = 'partial';
                }
            }
        } else {
            return redirect('/schoolClosure/' . Auth::user()->id);
        }
    
        return view('schoolClosure.index')->withSchools($schools)->withType($type);
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
