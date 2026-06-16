<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Agenda;

class ActivityController extends Controller
{
    public function create()
    {
        $agendas = Agenda::where('user_id', auth()->id())->get();

        return view('activities.create', compact('agendas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'name' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);

        Activity::create([
            'agenda_id' => $request->agenda_id,
            'name' => $request->name,
            'description' => $request->description,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'color' => $request->color,
        ]);

        return back();
    }

    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }
}
