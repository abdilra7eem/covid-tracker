<?php

namespace App\Http\Controllers;

use App\Incident;
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
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->account_type == 1) {
            $incidents = Incident::join('users', 'incidents.user_id', 'users.id')
                    ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 2) {
            $incidents = Incident::join('users', 'incidents.user_id', 'users.id')
                    ->where('users.directorate_id', Auth::user()->directorate_id)
                    ->inRandomOrder()->paginate(25);
        } elseif (Auth::user()->account_type == 3) {
            $incidents = Incident::where('user_id', Auth::user()->id)
                    ->join('users', 'incidents.user_id', 'users.id')
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
        return 'incident create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'incident store';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        return 'incident show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        return 'incident edit';

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
        return 'incident destroy';

    }
}
