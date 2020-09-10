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

    public function index()
    {
        if (!Auth::user()){
            return redirect('/login');
        }
        
        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if (Auth::user()->account_type == 1) {
            $incidents = Incident::with('user')
                ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 2) {
            $incidents = User::where('directorate_id', Auth::user()->directorate_id)
                ->join('incidents', 'users.id', 'incidents.user_id')
                ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 3) {
            $incidents = Incident::where('user_id', Auth::user()->id)
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
            'person_id'     => ['bail', 'required', 'integer', 'min:100000000','max:4299999999'],
            
            'person_phone_primary'     => ['bail', 'required', 'min:9','max:10', 'regex:/^0[0-9()-]+$/'],
            'person_phone_secondary'   => ['bail', 'max:10', 'regex:/^0[0-9()-]+$/'],

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

        $incident->notes = $request->notes;


        $incident->save();
        return redirect('/incident'.$incident->id)->with('success', 'Incident Created');

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
            // dd([
            //     "allowed" => $allowed,
            //     "user type" => 1
            // ]);
        } elseif(Auth::user()->id == $incident->user_id){
            $allowed = true;
            // dd([
            //     "allowed" => $allowed,
            //     "user type" => 3,
            //     "user_id" => $incident->user_id,
            // ]);
        } elseif((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $incident->user->directorate_id)){
            $allowed = true;
            // dd([
            //     "allowed" => $allowed,
            //     "user type" => 2,
            //     "directorate_id" => $incident->user->directorate_id,
            // ]);
        } else {
            $allowed = false;
            // dd('Not Authorized');
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

        //Check if directorate exists before deleting
        if (!isset($incident)){
            return redirect('/incident')->with('error', 'Not Found');
        }

        // Check for correct user
        if(Auth::user()->id !== $incident->user_id){
            return redirect('/incident')->with('error', 'Unauthorized');
        }

        return view('incident.edit')->with('incident', $incident);
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
        return 'incident update';

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
            abort(403, 'Not Authorized');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        if(Auth::user()->id == $schoolClosure->user_id){
            if($incident->deleted == false){
                $schoolClosure->deleted = true;
                $message = 'تم حذف سجل الحالة.';
            } else {
                $incident->deleted = false;
                $message = 'تم استرجاع السجل المحذوف';
            }
            $incident->save();
            return back()->withSuccess($message);
        }
        return back()->withError('يمكن فقط لحساب المدرسة ذات العلاقة حذف سجل الإغلاق');
    }
}
