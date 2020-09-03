<?php

namespace App\Http\Controllers;

use App\School;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class SchoolController extends Controller
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

    public function index()
    {
        $directorate = (int) $request->input('directorate') ?? 0;
        if (Auth::user()->account_type == 1) {
            if($directorate = 0){
                $schools = User::where('account_type', 3)
                    ->with('school')
                    ->inRandomOrder()->paginate(25);
            } else {
                $schools = User::where('account_type', 3)
                    ->where('directorate_id', $directorate)
                    ->with('school')
                    ->inRandomOrder()->paginate(25);
            }
        } elseif (Auth::user()->account_type == 2) {
            $schools = User::where('directorate_id', Auth::user()->directorate_id)
                    ->where('account_type', 3)
                    ->with('school')
                    ->inRandomOrder()->paginate(25);
        } else {
            return redirect('/school/' . Auth::user()->school->id);
        }
        
        return view('school.index')->withSchools($schools);
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
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        if(Auth::user()->account_type == 1){
            return view('school.show')->withSchool($school);
        }
        
        if(Auth::user()->id == $school->user_id){
            return view('school.show')->withSchool($school);
        }
        
        if((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $school->user->directorate_id)){
            return view('school.show')->withSchool($school);
        }

        abort(403, 'Not Authorized');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        //
    }
}
