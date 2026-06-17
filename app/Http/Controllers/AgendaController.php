<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Activity;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::where('user_id', auth()->id())->get();

        return view('agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request)
    {
        Agenda::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('agendas.index');
    }

    public function show(Request $request, Agenda $agenda)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);

        $current = Carbon::create($year, $month, 1);

        $start = $current->copy()->startOfMonth();
        $end = $current->copy()->endOfMonth();

        $days = collect();

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days->push($date->copy());
        }

        $activities = $agenda->activities()
            ->whereBetween('start_datetime', [$start, $end])
            ->get();

        return view('agendas.show', compact(
            'agenda',
            'days',
            'activities',
            'current'
        ));
    }

    public function edit(Agenda $agenda)
    {
        return view('agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $agenda->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('agendas.show', $agenda);
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agendas.index');
    }
}
