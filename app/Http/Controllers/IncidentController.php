<?php

namespace App\Http\Controllers;

use App\Incident;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class IncidentController extends Controller
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
            $directorates = Incident::where('deleted', true)
                ->paginate(25);
            return view('incident.index')->withIncidents($incidents);
        }

        if (Auth::user()->account_type == 1) {
            $incidents = Incident::where('deleted', false)
                ->with('user')
                ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 2) {
            $incidents = User::where('deleted', false)
                ->where('directorate_id', Auth::user()->directorate_id)
                ->join('incidents', 'users.id', 'incidents.user_id')
                ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 3) {
            $incidents = Incident::where('deleted', false)
                ->where('user_id', Auth::user()->id)
                ->with('user')
                ->inRandomOrder()->paginate(25);
        } else {
            abort(403, 'Unauthorized action.');
        }
        return view('incident.index')->withIncidents($incidents);
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
            return view('incident.create');
        }

        return redirect('/incident')->withError('يمكن فقط لحساب مدرسة إنشاء سجل حالة');
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
            return redirect()->withError('يمكن فقط لحساب مدرسة إنشاء سجل حالة');
        }

        // dd($request->notes);
        // $notes = htmlspecialchars(filter_input(INPUT_GET, $request->notes), ENT_COMPAT, 'UTF-8');
        // dd($notes);
        $request->validate([
            'sex'           => ['bail', 'required','in:male,female'],
            'job'           => ['bail', 'required','in:student,teacher,admin'],
            'type'          => ['bail', 'required','in:suspected,confirmed'],

            'person_name'   => ['bail', 'required','min:10','max:50'],
            'person_id'     => ['bail', 'required', 'min:9', 'max:9', 'regex:/^[0-9]+$/'],
            
            'person_phone_primary'     => ['bail', 'required', 'min:9','max:15', 'regex:/^0[0-9\-x\.]+$/'],
            'person_phone_secondary'   => ['bail', 'max:10', 'regex:/^0[0-9\-x\.]+$/'],

            // 'date'  => ['bail', 'required','regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
            'date'  => ['bail', 'required', 'date_format:Y-m-d', 'regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
            'notes' => ['bail', 'max:255'],
        ]);

        if($request->job == "teacher"){
            $grade = 13;
            $grade_section = 0;
        }elseif($request->job == "admin"){
            $grade = 14;
            $grade_section = 0;
        }else{
            $request->validate([
                'grade'         => ['bail', 'required_if:job,==,student', 'integer', 'between:1,12'],
                'grade_section' => ['bail', 'required_if:job,==,student', 'integer', 'between:1,15'],
            ]);
            $grade = $request->grade;
            $grade_section = $request->grade_section;
        }

        if($request->type == 'suspected'){
            $request->validate([
                'suspect_type'  => ['bail', 'required','in:personal,doc,gov'],
            ]);
            if($request->suspect_type == 'personal') {
                $suspect_type = 1;
            }elseif($request->suspect_type == 'doc'){
                $suspect_type = 2;
            } else {
                $suspect_type = 3;
            }
        } else {
            $suspect_type = null;
        }


        if($request->sex == "male"){
            $male = true;
        } else {
            $male = false;
        }

        // if(isset($request->notes)){
        //     $request->validate([
        //         'notes' => ['bail', 'max:255', 'regex:/^[\u0600-\u06FF ]+$/'],
        //     ]);
        // }

        $incident = new Incident;
        $incident->user_id = Auth::user()->id;
        $incident->male = $male;
        $incident->grade = $grade;
        $incident->grade_section = $grade_section;
        $incident->person_name = $request->person_name;
        $incident->person_id = $request->person_id;
        $incident->person_phone_primary = $request->person_phone_primary;
        $incident->person_phone_secondary = $request->person_phone_secondary;
        $incident->grade = $grade;

        if($request->type == 'suspected'){
            $incident->suspected_at = $request->date;
            $incident->suspect_type = $suspect_type;
        } else {
            $incident->confirmed_at = $request->date;
        }

        $incident->notes = strip_tags($request->notes);
        $incident->last_editor = Auth::user()->id; 
        $incident->last_editor_ip = $request->ip();

        $incident->save();
        return redirect('/incident/'.$incident->id)->with('success', 'Incident Created');

        // dd($incident);
        // return 'incident store';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        if (!Auth::user()){
            return redirect('/login');
        }
        

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        $allowed = false;

        if(Auth::user()->account_type == 1){
            $allowed = true;
        }elseif($incident->deleted == true){
            $allowed = false;
        } elseif(Auth::user()->id == $incident->user_id){
            $allowed = true;
        } elseif((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $incident->user->directorate_id)){
            $allowed = true;
        } else {
            $allowed = false;
        }

        if($allowed == true) {
            $other = Incident::where('person_id', $incident->person_id)
                ->where('id', '!=', $incident->id)
                ->orderBy('id', 'DESC')->get();
            return view('incident.show')
                ->withIncident($incident)
                ->withOther($other);
        }

        abort(403, 'Not Authorized');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        //Check if directorate exists before updating
        if (!isset($incident)){
            return redirect('/incident')->with('error', 'Not Found');
        }

        // Check for correct user
        if(Auth::user()->id == $incident->user_id){
            return view('incident.edit')->with('incident', $incident);
        }

        if(Auth::user()->id == 1){
            return view('incident.edit')->with('incident', $incident);
        }

        return redirect('/incident')->with('error', 'Unauthorized');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        //Check if incident exists before updating
        if (!isset($incident)){
            return redirect('/incident')->with('error', 'Not Found');
        }

        // Check for correct user & handle request
        if( (Auth::user()->id == $incident->user_id) ||
            (Auth::user()->id == 1))
        {
            // Person name change if super-admin
            if(Auth::user()->id == 1){
                if($incident->person_name != $request->person_name){
                    $request->validate([
                        'person_name'   => ['bail', 'required','min:10','max:50'],
                    ]);
                    $incident->person_name = $request->person_name;

                    $incident->last_editor = Auth::user()->id;
                    $incident->last_editor_ip = $request->ip();
                }
            }

            // Check, Validate and Handle personal info
            if( ($incident->person_id != $request->person_id) ||
                ($incident->person_phone_primary != $request->person_phone_primary) ||
                ($incident->person_phone_secondary != $request->person_phone_secondary) ||
                ($incident->date != $request->date)
                ){
                    $request->validate([    
                        'person_id'     => ['bail', 'required', 'min:9', 'max:9', 'regex:/^[0-9]+$/'],
                        
                        'person_phone_primary'     => ['bail', 'required', 'min:9','max:15', 'regex:/^0[0-9\-x\.]+$/'],
                        'person_phone_secondary'   => ['bail', 'max:10', 'regex:/^0[0-9\-x\.]+$/'],
                    ]);

                    $incident->person_id = $request->person_id;
                    $incident->person_phone_secondary = $request->person_phone_secondary;
                    $incident->person_phone_primary = $request->person_phone_primary;

                    $incident->last_editor = Auth::user()->id;
                    $incident->last_editor_ip = $request->ip();
            }

            // Check and handle notes changes
            if($incident->notes != $request->notes){
                $request->validate([    
                    'notes' => ['bail', 'max:255'],
                ]);

                $incident->notes = $request->notes;
                $incident->last_editor = Auth::user()->id;
                $incident->last_editor_ip = $request->ip();
            }

            // Check old status

            if($incident->closed_at != null){
                $old_status = "closed";
            }elseif($incident->confirmed_at != null){
                $old_status = "confirmed";
            }else{
                $old_status = "suspected";
            }

            // Status change check & handling

            // if($request->type != $old_status) {

                // Validating input
                $type = null;
                if($request->type != $old_status) {
                    if($old_status == "suspected"){
                        $request->validate([    
                            'type' => ['bail', 'required','in:suspected,confirmed,closed'],
                        ]);
                        $type = $request->type;
                    }elseif($old_status == "confirmed"){
                        $request->validate([    
                            'type' => ['bail', 'required','in:confirmed,closed'],
                        ]);
                        $type = $request->type;
                    }
                }

                // handling input
                if($type == 'confirmed'){
                    $request->validate([    
                        'date'  => ['bail', 'required', 'date_format:Y-m-d', 'regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
                    ]);
                    $incident->confirmed_at = $request->date;

                    $incident->last_editor = Auth::user()->id;
                    $incident->last_editor_ip = $request->ip();
                }elseif($type == 'closed'){
                    $request->validate([
                        'close_type' => ['bail', 'required','in:falsepositive,recovery,death'],
                        'date'  => ['bail', 'required', 'date_format:Y-m-d', 'regex:/^202[0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/'],
                    ]);

                    $incident->closed_at = $request->date;
                    if($request->close_type == "falsepositive"){
                        $incident->close_type = 1;
                    }elseif($request->close_type == "recovery"){
                        $incident->close_type = 2;
                    }elseif($request->close_type == "death"){
                        $incident->close_type = 3;
                    }else{
                        abort(500, 'Unknown Error in close_type');
                    }


                    $incident->last_editor = Auth::user()->id;
                    $incident->last_editor_ip = $request->ip();

                }

            // === the following code is for future proofing === //
            // === uncomment if suspected type can be changed === //
            /*
                }elseif( ($old_status == "suspected") && ($request->type == "suspected") ){
                    if($request->suspect_type == "personal"){
                        $sustype = 1;
                    }elseif($request->suspect_type == "doc"){
                        $sustype = 2;
                    }elseif($request->suspect_type == "gov"){
                        $sustype = 3;
                    }else{
                        abort(500, 'Unknown Error in suspect_type');
                    }
                
                    $incident->last_editor = Auth::user()->id;
                    $incident->last_editor_ip = $request->ip();
            */
            // }

            $incident->save();
            return redirect('/incident/'.$incident->id)->withSuccess('تم تحديث معلومات الحالة بنجاح.');
        }

        return redirect('/incident')->with('error', 'Unauthorized');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if(Auth::user()->account_type == 3){
            return back()->withError('لحذف السجل تواصل مع مشرف من قسم متابعة الميدان');
        }

        if($incident->deleted == false){
            if((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $incident->user->directorate_id)){
                $incident->deleted = true;
                $incident->last_editor = Auth::user()->id; 
                $incident->last_editor_ip = $request->ip();

                $incident->save();
                $message = 'تم حذف سجل الحالة.';
                return back()->withSuccess($message);
            } else {
                return back()->withError('لا يمكنك حذف هذا السجل. لحذفه، تواصل مع مشرف قسم متابعة الميدان في المديرية التي يتبع لها هذا السجل.');
            }
        } else {
            if(Auth::user()->account_type == 1){
                $incident->deleted = false;
                $incident->last_editor = Auth::user()->id; 
                $incident->last_editor_ip = $request->ip();

                $incident->save();
                $message = 'تم استرجاع السجل المحذوف';
                return back()->withSuccess($message);
            }else{
                return back()->withError('لا يمكنك استرجاع هذا السجل. لاسترجاعه، تواصل مع إدارة البرنامج.');
            }
        }
        abort('Not Authorized');
    }
}
