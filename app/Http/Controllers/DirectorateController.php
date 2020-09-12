<?php

namespace App\Http\Controllers;

use App\Directorate;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DirectorateController extends Controller
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
            $directorates = Directorate::where('deleted', true)
                ->paginate(25);
            return view('directorate.index')->withDirectorates($directorates);
        }

        if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2) {
            $directorates = Directorate::where('deleted', false)->get();
            return view('directorate.index')->withDirectorates($directorates);
        }
        return redirect('/directorate/' . Auth::user()->directorate_id);
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
        
        // The code is written this way to facilitate editing the code & 
        // giving permissions to all admins to edit in the future, while 
        // avoiding edits to the name and identifier.

        if(Auth::user()->id != 1) {
            return redirect('/directorate')->withError('Only super-admin (root) can create a directorate');
        }

        if(Auth::user()->id == 1) {
            return view('directorate.create');
        }

        abort(403, 'Not Authorized');
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
        
        // The code is written this way to facilitate editing the code & 
        // giving permissions to all admins to edit in the future, while 
        // avoiding edits to the name and identifier.
        
        if(Auth::user()->id != 1) {
            return redirect('/directorate')->withError('Only super-admin (root) can create a directorate');
        }

        if(Auth::user()->id == 1){

            $request->validate([
                'name' => ['bail','required','min:3','max:15', 'regex:/^[a-zA-Z1-9]+$/','unique:directorates'],
                'name_ar' => ['bail', 'required','min:3','max:15'],
                'email' => ['bail', 'required','min:10','max:50', 'email'],
                'phone_number' => ['bail', 'required', 'min:9','max:18', 'regex:/^0[0-9\-x\.]+$/'],
                'head_of_directorate' => ['bail', 'required', 'min:7','max:100'],
                'school_count' => ['bail', 'required', 'min:2', 'max:3', 'regex:/^[0-9]+$/'],
            ]);

            $directorate = new Directorate;
            $directorate->name = $request->name;
            $directorate->name_ar = $request->name_ar;
            $directorate->email = strtolower($request->email);
            $directorate->phone_number = $request->phone_number;
            $directorate->head_of_directorate = $request->head_of_directorate;
            $directorate->school_count = $request->school_count;
            $directorate->last_editor = Auth::user()->id;
            $directorate->save();
            return redirect('/directorate')->with('success', 'تم إنشاء مديرية جديدة بنجاح');
        }

        abort(403, 'Not authorized');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Directorate  $directorate
     * @return \Illuminate\Http\Response
     */
    public function show(Directorate $directorate)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if( (Auth::user()->account_type != 3) || 
            (Auth::user()->directorate_id == $directorate->id) )
        {            
            if((Auth::user()->account_type != 1) && ($directorate->deleted == true)){
                return redirect('/directorate')->withError('غير مصرح لك عرض ملف مديرية محذوفة');
            }

            return view('directorate.show')->withDirectorate($directorate);
        } else {
            abort(403, 'Not Authorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Directorate  $directorate
     * @return \Illuminate\Http\Response
     */
    public function edit(Directorate $directorate)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        //Check if directorate exists before editing
        if (!isset($directorate)){
            return redirect('/directorate')->with('error', 'هذه المديرية غير موجودة');
        }

        // The code is written this way to facilitate editing the code & 
        // giving permissions to all admins to edit in the future, while 
        // avoiding edits to the name and identifier.

        if(Auth::user()->id != 1) {
            return redirect('/directorate')->withError('Only super-admin (root) can edit a directorate');
        }

        if(Auth::user()->id == 1){
            return view('directorate.edit')->with('directorate', $directorate);
        }

        return redirect('/directorate')->with('error', 'Unauthorized');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Directorate  $directorate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directorate $directorate)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        // The code is written this way to facilitate editing the code & 
        // giving permissions to all admins to edit in the future, while 
        // avoiding edits to the name and identifier.

        if(Auth::user()->id != 1) {
            return redirect('/directorate')->withError('Only super-admin (root) can edit a directorate');
        }

        if(Auth::user()->id == 1){

            $request->validate([
                'email' => ['bail', 'required','min:10','max:50', 'email'],
                'phone_number' => ['bail', 'required', 'min:9','max:18', 'regex:/^0[0-9\-x\.]+$/'],
                'head_of_directorate' => ['bail', 'required', 'min:7','max:100'],
                'school_count' => ['bail', 'required', 'min:2', 'max:3', 'regex:/^[0-9]+$/'],
            ]);

            if(Auth::user()->id == 1){
                $request->validate([
                    'name' => ['bail','required','min:3','max:15', 'regex:/^[a-zA-Z1-9]+$/','unique:directorates'],
                    'name_ar' => ['bail', 'required','min:3','max:15'],
                ]);

                $directorate->name = $request->name;
                $directorate->name_ar = $request->name_ar;
            }

            $directorate->email = strtolower($request->email);
            $directorate->phone_number = $request->phone_number;
            $directorate->head_of_directorate = $request->head_of_directorate;
            $directorate->school_count = $request->school_count;
            $directorate->last_editor = Auth::user()->id;
            $directorate->save();
            return redirect('/directorate/'.$directorate->id)->with('success', 'تم تحديث معلومات المديرية بنجاح.');
        }

        abort(403, 'Not authorized');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Directorate  $directorate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directorate $directorate)
    {
        if (!Auth::user()){
            abort(403, 'Not Authorized');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if(Auth::user()->account_type == 1) {
            if($directorate->deleted == false){
                $directorate->deleted = true;
                $message = 'تم حذف سجل المديرية.';
            } else {
                $directorate->deleted = false;
                $message = 'تم استرجاع السجل المحذوف';
            }
            $directorate->last_editor = Auth::user()->id;
            $directorate->save();
            return back()->withSuccess($message);
        } else {
            return back()->withError('لا يمكنك حذف سجل مديرية');
        }

    }
}
