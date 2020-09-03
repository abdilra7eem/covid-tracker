<?php

namespace App\Http\Controllers;

use App\School;
use App\User;
use App\Directorate;

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
            if($request->input("type") == "complete"){
                $schools = SchoolClosure::where("grade", ">", 12)
                    ->where("reopening_date", null)
                    ->orderBy("grade", "DESC")
                    ->with("user")->with("user.school")
                    ->get()->unique("user_id");
                $type = "complete";
            } else {
                $schools = SchoolClosure::where("reopening_date", null)
                    ->orderBy("grade", "DESC")
                    ->with("user")->with("user.school")
                    ->get()->unique("user_id");
                if($request->input("type") == "partial") {
                    $type = "partial";
                }
            }
        } elseif(Auth::user()->account_type == 2) {
            if($request->input("type") == "complete"){
                $schools = SchoolClosure::where("grade", ">", 12)
                    ->where("school_closures.reopening_date", null)
                    ->join("users", "school_closures.user_id", "users.id")
                    ->where("users.directorate_id", Auth::user()->directorate_id)
                    ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
                    ->orderBy("school_closures.grade", "DESC")
                    ->with("user")->with("user.school")
                    ->get()->unique("user_id");
                // $schools = SchoolClosure::where("grade", ">", 12)
                //     ->where("reopening_date", null)
                //     ->orderBy("grade", "DESC")
                //     ->join("users", "users.id", "school_closures.user_id")
                //     // ->with(["user" => function($x){
                //     //     $x->where("directorate_id",  Auth::user()->directorate_id);
                //     // }])
                //     ->where("directorate_id", Auth::user()->directorate_id)
                //     ->with("user.school")
                //     ->get()->unique("user_id");
                $type = "complete";
            } else {
                // $schools = User::where("directorate_id", Auth::user()->directorate_id)
                //     ->join("school_closures", "school_closures.user_id", "users.id")
                //     ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
                //     ->where("school_closures.reopening_date", null)
                //     ->orderBy("school_closures.grade", "DESC")
                //     ->with("school")->with("schoolClosure")
                //     ->get()->unique("user_id");
                $schools = SchoolClosure::where("school_closures.reopening_date", null)
                    ->join("users", "school_closures.user_id", "users.id")
                    ->where("users.directorate_id", Auth::user()->directorate_id)
                    ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
                    ->orderBy("school_closures.grade", "DESC")
                    ->with("user")->with("user.school")
                    ->get()->unique("user_id");
                if($request->input("type") == "partial") {
                    $type = "partial";
                }
            }
        } else {
            $schools = SchoolClosure::where("reopening_date", null)
                ->where("user_id", Auth::user()->id)
                ->with("user")->with("user.school")
                ->with("user.school")
                ->orderBy("school_closures.grade", "DESC")
                ->get()->unique("user_id");
        }

        // dd($schools);
        return view("schoolClosure.index")->withSchools($schools)->withType($type);
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
        $allowed = false;
        // dd($schoolClosure->user["directorate_id"]);
        if(Auth::user()->account_type == 1) {
            $allowed = true;
        }

        if(Auth::user()->id == $schoolClosure->user_id){
            $allowed = true;
        }

        if((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $schoolClosure->user["directorate_id"])){
            $allowed = true;
        }

        if($allowed == true) {
            $other = SchoolClosure::where("user_id", $schoolClosure->user_id)
                ->where("id", "!=", $schoolClosure->id)
                ->orderBy("id", "DESC")
                ->get();
            $current = SchoolClosure::where("user_id", $schoolClosure->user_id)
                ->where("reopening_date", null)
                ->orderBy("grade", "DESC")
                ->first();
            $info = [
                "user" => User::where("id", $schoolClosure->user_id)->first(),
                "school" => School::where("user_id", $schoolClosure->user_id)->first(),
                "directorate" => Directorate::where("id", $schoolClosure->user->directorate_id)->first(),
            ];

            return view("schoolClosure.show")
                ->withClosure($schoolClosure)
                ->withOther($other)
                ->withCurrent($current)
                ->withInfo($info);
        }

        abort(403, "Not Authorized");

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
