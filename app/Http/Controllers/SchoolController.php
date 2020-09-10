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
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        $this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        $directorate = 0;
        if(isset($request)){
            if($request->input('directorate') !== null){
                $directorate = (int) $request->input('directorate');
            }
        }
        
        if (Auth::user()->account_type == 1) {
            if($directorate == 0){
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
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if(Auth::user()->account_type == 3) {
            $school = School::where('user_id', Auth::user()->id)->first();
            if($school == null){
                return view('school.create')->withUser(Auth::user());
            } else {
                return redirect('/school/edit/'.$school->id);
            }
        }

        return redirect('/school')->withError('فقط حسابات المدارس يمكنها إنشاء ملف مدرسة');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if(Auth::user()->account_type != 3) {
            return redirect('/school')->withError('فقط حسابات المدارس يمكنها إنشاء ملف مدرسة');
        }

        $old_school = School::where('user_id', Auth::user()->id)->first();
        if($old_school != null){
            return redirect('/school/edit/'.Auth::user()->school->id)->withError('هناك ملف مدرسة مسجل مسبقًا لمدرستك. يمكنك تعديله، لكن لا يمكنك إنشاء ملف جديد');
        }

        $request->validate([
            'rented'                => ['bail', 'required', 'in:true,false'],
            'second_shift'          => ['bail', 'required', 'in:true,false'],
            'youngest_class'        => ['bail', 'required', 'integer', 'between:1,12'],
            'oldest_class'          => ['bail', 'required', 'integer', 'between:1,12'],
            'building_year'         => ['bail', 'required', 'integer', 'between:1780,2020'],
            'total_male_students'   => ['bail', 'required', 'integer', 'between:0,900'],
            'total_female_students' => ['bail', 'required', 'integer', 'between:0,900'],
            'total_male_staff'      => ['bail', 'required', 'integer', 'between:0,50'],
            'total_female_staff'    => ['bail', 'required', 'integer', 'between:0,50'],
            'number_of_classrooms'  => ['bail', 'required', 'integer', 'between:2,40'],
            'head_of_school'        => ['bail', 'required','min:10','max:50'],
        ]);

        if(isset($request->rented)){
            if($request->rented == "true"){
                $rented = true;
            }elseif($request->rented == "false"){
                $rented = false;
            }
        }

        if(isset($request->second_shift)){
            if($request->second_shift == "true"){
                $second_shift = true;
            }elseif($request->second_shift == "false"){
                $second_shift = false;
            }
        }

        if($request->oldest_class < $request->youngest_class){
            return back()->withError('يجب أن يكون "أكبر صف" أكبر من "أصغر صف".');
        }

        $total_students = $request->total_male_students + $request->total_female_students;

        if( ($total_students < 21) || ($total_students > 1200)){
            return back()->withError('يجب أن يكون عدد الطلاب منطقيًا.');
        }

        $total_staff = $request->total_male_staff + $request->total_female_staff;
        if( ($total_staff < 5) || ($total_staff > 55)){
            return back()->withError('يجب أن يكون عدد الموظفين منطقيًا.');
        }

        if( ($request->building_year > 2020) || ($request->building_year < 1781)){
            return back()->withError('لا يمكن أن تكون سنة البناء '.$request->building_year);
        }

        $school = new School;
        $school->rented = $rented;
        $school->second_shift = $second_shift;
        $school->youngest_class = $request->youngest_class;
        $school->oldest_class = $request->oldest_class;
        $school->total_male_students = $request->total_male_students;
        $school->total_female_students = $request->total_female_students;
        $school->total_male_staff = $request->total_male_staff;
        $school->total_female_staff = $request->total_female_staff;
        $school->number_of_classrooms = $request->number_of_classrooms;
        $school->building_year = (int) ($request->building_year - 1780);
        $school->head_of_school = $request->head_of_school;
        $school->user_id = Auth::user()->id;
        $school->save();

        return redirect('/school/'.Auth::user()->school->id)->withSuccess('تم تحديث معلومات المدرسة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(School $school)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
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
        
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        //Check if directorate exists before deleting
        if (!isset($school)){
            return redirect('/school')->with('error', 'Not Found');
        }

        // Check for correct user
        if(Auth::user()->id !== $school->user_id) {
            return redirect('/school')->with('error', 'Unauthorized');
        }

        return view('school.edit')->with('school', $school);
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
                
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        return back()->withError('لا يمكن حذف معلومات مدرسة، يمكنك فقط تعديلها.');
    }
}
