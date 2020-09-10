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

        if((Auth::user()->account_type == 1) && ($request->input('type') == 'banned')){
            $users = User::where('active', false)
                ->paginate(25);
        }

        $type = 'all';
        $directorate = (int) $request->input('directorate') ?? 0;
        if($request->input('type') == 'admins'){
            $type = 'admins';
        }elseif($request->input('type') == 'supervisors'){
            $type = 'supervisors';
        }

        if(Auth::user()->account_type == 1) {
            if($type == 'admins'){
                $users = User::where('account_type', 1)
                ->paginate(25);
            } elseif($type == 'supervisors') {
                if($directorate == 0) {
                    $users = User::where('account_type', 2)
                    ->paginate(25);
                } else {
                    $users = User::where('account_type', 2)
                    ->where('directorate_id', $directorate)
                    ->paginate(25);
                }
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
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if((Auth::user()->account_type == 1) || (Auth::user()->account_type == 2)) {
            return view('user.create');
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

        if((Auth::user()->account_type == 1) || (Auth::user()->account_type == 2)){
            if(Auth::user()->account_type == 1) {
                $request->validate([
                    'directorate_id' => ['bail','required','min:1','max:2', 'regex:/^[1-9]+$/','exists:directorates,id'],
                ]);
                $directorate_id = $request->directorate_id;
                $account_type = 2;
            } else {
                $directorate_id = Auth::user()->directorate_id;
                $account_type = 3;
            }
            $request->validate([
                'name' => ['bail', 'required','min:10','max:50'],
                'email' => ['bail', 'required','min:10','max:50', 'regex:/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/', 'unique:users'],
                'phone_primary' => ['bail', 'required', 'min:9','max:10', 'regex:/^0[0-9()-]+$/'],
                'phone_secondary' => ['bail', 'max:10', 'regex:/^0[0-9()-]+$/'],
                'gov_id' => ['bail', 'required', 'min:9','max:10', 'regex:/^[0-9]+$/', 'unique:users'],
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_primary = $request->phone_primary;
            $user->phone_secondary = $request->phone_secondary;
            $user->gov_id = $request->gov_id;
            $user->directorate_id = $directorate_id;
            $user->account_type = $account_type;
            $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            // dd($user);
            $user->last_editor = Auth::user()->id;
            $user->save();
            return redirect('/user')->with('success', 'User Created');
        }
        abort(403, 'Not authorized');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()){
            return redirect('/login');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }
        
        $user = User::where('id', $id)->first();

        if($user['account_type'] == 3){
            return redirect('/school/'. $user->school['id']);
        } elseif(Auth::user()->account_type == 1) {
            return view('user.show')->withUser($user);
        } elseif((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $user->directorate_id)) {
            return view('user.show')->withUser($user);
        } elseif(Auth::user()->account_type == 3) {
            if($user->active == false){
                abort(403, 'Not Authorized');
            } elseif(($user->account_type == 2) && ($user->directorate_id == Auth::user()->directorate_id)){
                return view('user.show')->withUser($user);
            } else {
                abort(403, 'Not Authorized');
            }
        } else {
            abort(403, 'Not Authorized');
        }
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
        if (!Auth::user()){
            abort(403, 'Not Authorized');
        }

        if (Auth::user()->active == false){
            return redirect('/inactive');
        }

        if(Auth::user()->account_type == 3) {
            abort(403, 'Not Authorized');
        }

        if( (Auth::user()->id == 1) || ((Auth::user()->account_type == 1) && ($user->account_type != 1)) || ((Auth::user()->account_type == 2) && (Auth::user()->directorate_id == $user->directorate_id) && ($user->account_type != 2)) ){
            $user = User::find($id);
            if($user->active == true){
                $user->active = false;
                $message = 'تم تعطيل الحساب ولن يتمكن من إنشاء أو تعديل أو عرض أيّ بيانات';
            } else {
                $user->active = true;
                $message = 'تم تفعيل الحساب وسيتمكن من إنشاء و تعديل  وعرض البيانات';
            }
            $user->last_editor = Auth::user()->id;
            $user->save();
            return back()->withSuccess($message);
        }

        abort(403, 'Not Authorized');
    }
}
