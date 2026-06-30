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
            'name'    => $request->name,
            'description' => $request->description,
            'color'   => $request->color,
        ]);

        return redirect()->route('agendas.index');
    }

    public function show(Request $request, Agenda $agenda)
    {
        $view  = $request->get('view', 'month');
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);
        $week  = (int) $request->get('week', now()->weekOfYear);
        $day   = (int) $request->get('day', now()->day);

        switch ($view) {
            case 'day':
                $current = Carbon::create($year, $month, $day);
                $start   = $current->copy()->startOfDay();
                $end     = $current->copy()->endOfDay();
                $days    = collect([$current->copy()]);
                break;

            case 'week':
                $current = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $start   = $current->copy()->startOfWeek();
                $end     = $current->copy()->endOfWeek();
                $days    = collect();
                for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                    $days->push($d->copy());
                }
                break;

            case 'year':
                $current = Carbon::create($year, 1, 1);
                $start   = $current->copy()->startOfYear();
                $end     = $current->copy()->endOfYear();
                $days    = collect();
                for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                    $days->push($d->copy());
                }
                break;

            default:
                $current = Carbon::create($year, $month, 1);
                $start   = $current->copy()->startOfMonth();
                $end     = $current->copy()->endOfMonth();
                $days    = collect();
                for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                    $days->push($d->copy());
                }
                break;
        }

        $activities = $agenda->activities()
            ->where('start_datetime', '<=', $end)
            ->where('end_datetime', '>=', $start)
            ->orderBy('start_datetime')
            ->get();

        return view('agendas.show', compact(
            'agenda', 'days', 'activities', 'current', 'view',
            'month', 'year', 'week', 'day'
        ));
    }

    public function edit(Agenda $agenda)
    {
        return view('agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $agenda->update([
            'name'        => $request->name,
            'description' => $request->description,
            'color'       => $request->color,
        ]);

        return redirect()->route('agendas.show', $agenda);
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agendas.index');
    }
}
