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
    
    public function index(Request $request)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }


        if((Auth::user()->account_type == 1) && ($request->input('type') == 'deleted')){
            $schools = SchoolClosure::where('deleted', true)
                ->paginate(25);
            return view('schoolClosure.index')->withShools($schools);
        }

        $type = "all";
        if (Auth::user()->account_type == 1) {
            if($request->input("type") == "complete"){
                $schools = SchoolClosure::where('deleted', false)
                    ->where("grade", ">", 12)
                    ->where("reopening_date", null)
                    ->orderBy("grade", "DESC")
                    ->distinct('user_id')
                    ->orderBy('closure_date', 'DESC')
                    ->with("user")->with("user.school")
                    ->paginate(25);
                $type = "complete";
            } elseif($request->input("type") == "partial") {
                $schools = SchoolClosure::where('deleted', false)
                    ->where("reopening_date", null)
                    ->orderBy("grade", "DESC")
                    ->distinct('user_id')
                    ->where('grade', '<', 13)
                    ->orderBy('closure_date', 'DESC')
                    ->with("user")->with("user.school")
                    ->paginate(25); 
                $type = "partial";
            }else {
                $schools = SchoolClosure::where('deleted', false)
                    ->where("reopening_date", null)
                    ->orderBy("updated_at", "DESC")
                    ->with("user")->with("user.school")
                    ->paginate(25);
            }
        } elseif(Auth::user()->account_type == 2) {
            if($request->input("type") == "complete"){
                $schools = SchoolClosure::where('deleted', false)
                    ->where("grade", ">", 12)
                    ->where("school_closures.reopening_date", null)
                    ->orderBy("school_closures.grade", "DESC")
                    ->distinct('user_id')
                    ->join("users", "school_closures.user_id", "users.id")
                    ->where("users.directorate_id", Auth::user()->directorate_id)
                    ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
                    ->with("user")->with("user.school")
                    ->paginate(25);
                    // ->get()->unique("user_id");
                $type = "complete";
            } else {
                $schools = SchoolClosure::where('deleted', false)
                    ->where("school_closures.reopening_date", null)
                    // ->where('user_id', Auth::user()->id)
                    ->join("users", "school_closures.user_id", "users.id")
                    ->where("users.directorate_id", Auth::user()->directorate_id)
                    ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
                    ->orderBy("school_closures.grade", "DESC")
                    ->with("user")->with("user.school")
                    ->paginate(25);
                if($request->input("type") == "partial") {
                    $type = "partial";
                }
            }
        } else {
            $schools = SchoolClosure::where('deleted', false)
                ->where("reopening_date", null)
                ->where("user_id", Auth::user()->id)
                ->with("user")->with("user.school")
                ->orderBy("school_closures.grade", "DESC")
                ->paginate(25);
                // ->get()->unique("user_id");
        }
        // if("type" != "all"){
            return view("schoolClosure.index")->withSchools($schools)->withType($type);
        // }else{
        //     return view("schoolClosure.index")->withSchools($schools)->withType($type);
        // }
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
            $closure = SchoolClosure::where('user_id', Auth::user()->id)
                ->where('reopening_date', null)
                ->orderBy('grade', 'DESC')
                ->first();
            if($closure != null){
                if($closure->grade == 15){
                    return redirect('/schoolClosure')->withError('المدرسة مغلقة بالكامل. لا يمكن إنشاء سجل إغلاق جديد');
                } else {
                    return view('schoolClosure.create')
                        ->withCurrent($closure->grade)
                        ->withUser(Auth::user())
                        ->withSchool(Auth::user()->school);
                }
            } else {
                return view('schoolClosure.create')
                    ->withCurrent(0)
                    ->withUser(Auth::user())
                    ->withSchool(Auth::user()->school);
            }
        }

        return redirect('/schoolClosure')->withError('Error', 'فقط حسابات المدارس يمكنها إنشاء سجل إغلاق مدرسة');
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

        if(Auth::user()->account_type != 3){
            return redirect('/schoolClosure')->withError('لا يمكنك إنشاء سجل إغلاق لأن حسابك ليس حساب مدرسة');
        }

        $request->validate([
            'closure_date'      => ['bail', 'required', 'date_format:Y-m-d', 'regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
            'type'              => ['bail', 'required', 'integer', 'in:13,14,15,1'],
        ]);

        $prev = SchoolClosure::where('user_id', Auth::user()->id)
            ->where('reopening_date', null)
            ->where('grade', '>', 12)
            ->where('deleted', false)
            ->orderBy('grade', 'DESC')
            ->first();

        if($prev->grade >= $request->type){
            return back()->withError('عُذرًا، لا يمكن تسجيل هذا الإغلاق. تأكد من إدخال معلومات صحيحة.');
        }

        $conflict = SchoolClosure::where('user_id', Auth::user()->id)
            ->where('grade', $request->grade)
            ->where('grade_section', $request->grade_section)
            ->where('reopening_date', null)
            ->where('deleted', false)
            ->first();

        if($conflict != null){
            return back()->withError('لا يمكن إنشاء هذا السجل بسبب وجود تعارض مع سجل آخر. هل سبق وأنشأت سجلًا لهذا الإغلاق؟.');
        }
        
        if($request->type == 1){
            $request->validate([
                'grade'             => ['bail', 'required', 'integer', 'min:1', 'max:12'],
                'grade_section'     => ['bail', 'required', 'integer', 'min:1', 'max:15'],
                'affected_students' => ['bail', 'required', 'integer', 'min:5', 'max:999'],
            ]);

            $prev = SchoolClosure::where('user_id', Auth::user()->id)
                ->where('reopening_date', null)
                ->where('grade', $request->grade)
                ->where('grade_section', $request->grade_section)
                ->orderBy('grade', 'DESC')
                ->first();

            if($prev != null){
                return back()->withError('عُذرًا، هذه الشعبة مغلقة من قبل. تأكد من إدخال معلومات صحيحة.');
            }
    
            $grade = $request->grade;
            $grade_section = $request->grade_section;
            $affected_students = $request->affected_students;

        }else{
            $grade = $request->type;
            $grade_section = null;
            $school = School::where('id', Auth::user()->id)->first();
            $affected_students = $school->total_male_students + $school->total_female_students;
        }

        $closure = new SchoolClosure;
        $closure->grade = $grade;
        $closure->grade_section = $grade_section;
        $closure->closure_date = $request->closure_date;
        $closure->user_id = Auth::user()->id;
        $closure->affected_students = $affected_students;
        if(isset($request->notes)){
            $closure->notes = strip_tags($request->notes);
        }
        $closure->last_editor = Auth::user()->id; 
        $closure->last_editor_ip = $request->ip();

        $closure->save();
        return redirect('/schoolClosure/'.$closure->id)->withSuccess('تم إنشاء سجل الإغلاق');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolClosure $schoolClosure)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        $allowed = false;
        // dd($schoolClosure->user["directorate_id"]);
        if(Auth::user()->account_type == 1) {
            $allowed = true;
        }elseif($schoolClosure->deleted == true){
            $allowed = false;
        }elseif(Auth::user()->id == $schoolClosure->user_id){
            $allowed = true;
        }elseif((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $schoolClosure->user["directorate_id"])){
            $allowed = true;
        }else{
            $allowed = false;
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

            if($info['user'] == null){
                return back()->withError('حساب المدرسة المنشئة لهذا السجل غير صحيح. من فضلك، تواصل مع إدارة البرنامج.');
            }elseif($info['school'] == null){
                return back()->withError('ملف المدرسة المنشئة لهذا السجل غير موجود. من فضلك، اطلب من المدرسة تعبئة ملف معلوماتها.');
            }elseif($info['directorate'] == null){
                return back()->withError('هذا السجل يتبع لمديرية حسابها غير موجود أو معطل. من فضلك تواصل مع إدارة البرنامج.');
            }

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
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        //Check if closure exists before deleting
        if (!isset($schoolClosure)){
            return redirect('/schoolClosure')->with('error', 'Not Found');
        }

        // Check for correct user
        if(Auth::user()->id !== $schoolClosure->user_id){
            return redirect('/schoolClosure')->with('error', 'Unauthorized');
        }

        return view('schoolClosure.edit')->with('closure', $schoolClosure);
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
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        //Check if closure exists before updating
        if (!isset($schoolClosure)){
            return redirect('/incident')->with('error', 'Not Found');
        }

        dd($request);

        // Check for correct user & handle request
        if(Auth::user()->id == $schoolClosure->user_id){

            if($schoolClosure->reopening_date == null){
                $request->validate([
                    'reopening' => ['bail', 'required', 'in:false, true'],
                ]);

                if($request->reopening == 'true'){
                    $request->validate([
                        'date'      => ['bail', 'required', 'date_format:Y-m-d', 'regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
                    ]);

                    $schoolClosure->reopening_date = $request->date;
                    $incident->last_editor = Auth::user()->id; 
                    $incident->last_editor_ip = $request->ip();
                }
            }

            if($schoolClosure->notes != $request->notes){
                $request->validate([
                    'notes'     => ['bail', 'max:255'],
                ]);

                $schoolClosure->notes = strip_tags($request->notes);
                $incident->last_editor = Auth::user()->id; 
                $incident->last_editor_ip = $request->ip();
            }

            $schoolClosure->save();
            return redirect('/schoolClosure/'.$schoolClosure->id)
                ->withSuccess('تم تحديث معلومات الإغلاق بنجاح.');

        }

        Abort(500, 'Unknown error');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolClosure  $schoolClosure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SchoolClosure $schoolClosure)
    {
        if (!Auth::user()){
            abort(403, 'Not Authorized');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        if(Auth::user()->account_type == 3){
            return back()->withError('لحذف السجل تواصل مع مشرف من قسم متابعة الميدان');
        }

        if($schoolClosure->deleted == false){
            if((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $schoolClosure->user->directorate_id)){
                $schoolClosure->deleted = true;
                $schoolClosure->last_editor = Auth::user()->id; 
                $schoolClosure->last_editor_ip = $request->ip();

                $schoolClosure->save();
                $message = 'تم حذف سجل الإغلاق.';
                return back()->withSuccess($message);
            } else {
                return back()->withError('لا يمكنك حذف هذا السجل. لحذفه، تواصل مع مشرف قسم متابعة الميدان في المديرية التي يتبع لها هذا السجل.');
            }
        } else {
            if(Auth::user()->account_type == 1){
                $schoolClosure->deleted = false;
                $schoolClosure->last_editor = Auth::user()->id; 
                $schoolClosure->last_editor_ip = $request->ip();

                $schoolClosure->save();
                $message = 'تم استرجاع السجل المحذوف';
                return redirect('/schoolClosure')->withSuccess($message);
            }else{
                return back()->withError('لا يمكنك استرجاع هذا السجل. لاسترجاعه، تواصل مع إدارة البرنامج.');
            }
        }
        abort('Not Authorized');

        // if(Auth::user()->id == $schoolClosure->user_id){
        //     if($schoolClosure->deleted == false){
        //         $schoolClosure->deleted = true;
        //         $message = 'تم حذف سجل الإغلاق.';
        //     } else {
        //         $schoolClosure->deleted = false;
        //         $message = 'تم استرجاع السجل المحذوف';
        //     }
        //     $schoolClosure->save();
        //     return back()->withSuccess($message);
        // }
        // return back()->withError('يمكن فقط لحساب المدرسة ذات العلاقة حذف سجل الإغلاق');
    }
}
