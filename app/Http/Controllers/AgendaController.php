<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Activity;
use App\Models\AgendaMember; // Added the member model
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{

    // index agenda
    public function index()
    {
        $userId = auth()->id();

        $joinedAgendaIds = AgendaMember::where('user_id', $userId)
            ->pluck('agenda_id');

        $agendas = Agenda::where('user_id', $userId)
            ->orWhereIn('id', $joinedAgendaIds)
            ->get();

        return view('agendas.index', compact('agendas'));
    }

    // create agenda
    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $agenda = Agenda::create([
                'user_id'     => auth()->id(),
                'name'        => $request->name,
                'description' => $request->description,
                'color'       => $request->color,
            ]);

            AgendaMember::create([
                'agenda_id' => $agenda->id,
                'user_id'   => auth()->id(),
                'joined_at' => now(),
            ]);
        });

        return redirect()->route('agendas.index');
    }

    // show agenda
    public function show(Request $request, Agenda $agenda)
    {
        $isMember = AgendaMember::where('agenda_id', $agenda->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($agenda->user_id !== auth()->id() && !$isMember) {
            abort(403, 'You do not have access to this agenda.');
        }

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

    // edit agenda
    public function edit(Agenda $agenda)
    {
        if ($agenda->user_id !== auth()->id()) {
            abort(403, 'Only the agenda owner can edit this.');
        }

        return view('agendas.edit', compact('agenda'));
    }

    // update agenda
    public function update(Request $request, Agenda $agenda)
    {
        if ($agenda->user_id !== auth()->id()) {
            abort(403, 'Only the agenda owner can update this.');
        }

        $agenda->update([
            'name'        => $request->name,
            'description' => $request->description,
            'color'       => $request->color,
        ]);

        return redirect()->route('agendas.show', $agenda);
    }

    // destroy agenda
    public function destroy(Agenda $agenda)
    {
        if ($agenda->user_id !== auth()->id()) {
            abort(403, 'Only the agenda owner can delete this.');
        }

        $agenda->delete();

        return redirect()->route('agendas.index');
    }
}
