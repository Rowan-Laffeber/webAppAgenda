@extends('layouts.app')

@section('title', $agenda->name)

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 border border-slate-100">

            {{-- HEADER --}}
            <div class="flex items-center justify-between border-b border-slate-100 pb-6 mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">
                        {{ $agenda->name }}
                    </h1>
                    <p class="text-sm text-slate-400">
                        Maand overzicht
                    </p>
                </div>

                <a href="{{ route('activities.create') }}"
                   class="bg-slate-900 text-white px-5 py-3 rounded-xl text-xs uppercase tracking-widest">
                    + Activiteit
                </a>
            </div>

            {{-- MAAND NAVIGATIE --}}
            @php
                use Carbon\Carbon;

                $prev = $current->copy()->subMonth();
                $next = $current->copy()->addMonth();
            @endphp

            <div class="flex items-center justify-between mb-6">

                <a href="{{ route('agendas.show', [
                'agenda' => $agenda->id,
                'month' => $prev->month,
                'year' => $prev->year
            ]) }}"
                   class="px-4 py-2 bg-slate-100 rounded-lg text-sm hover:bg-slate-200">
                    ← Vorige
                </a>

                <h2 class="text-lg font-bold text-slate-800">
                    {{ $current->format('F Y') }}
                </h2>

                <a href="{{ route('agendas.show', [
                'agenda' => $agenda->id,
                'month' => $next->month,
                'year' => $next->year
            ]) }}"
                   class="px-4 py-2 bg-slate-100 rounded-lg text-sm hover:bg-slate-200">
                    Volgende →
                </a>

            </div>

            {{-- WEEKDAGEN --}}
            <div class="grid grid-cols-7 text-center text-xs font-bold text-slate-500 mb-2">
                <div>Ma</div>
                <div>Di</div>
                <div>Wo</div>
                <div>Do</div>
                <div>Vr</div>
                <div>Za</div>
                <div>Zo</div>
            </div>

            {{-- KALENDER GRID --}}
            <div class="grid grid-cols-7 gap-2">

                @php
                    $startOfMonth = $days->first();
                    $emptyCells = $startOfMonth->copy()->startOfMonth()->dayOfWeekIso - 1;
                @endphp

                {{-- lege cells --}}
                @for ($i = 0; $i < $emptyCells; $i++)
                    <div></div>
                @endfor

                {{-- dagen --}}
                @foreach ($days as $day)

                    @php
                        $dayActivities = $activities->filter(function ($activity) use ($day) {
                            return Carbon::parse($activity->start_datetime)->isSameDay($day);
                        });
                    @endphp

                    <div class="min-h-[110px] border border-slate-200 rounded-xl bg-slate-50 p-2">

                        <div class="text-xs font-bold text-slate-500">
                            {{ $day->format('d') }}
                        </div>

                        <div class="mt-1 space-y-1">
                            @foreach ($dayActivities as $activity)
                                <div class="text-[10px] px-2 py-1 rounded bg-indigo-100 text-slate-800 truncate">
                                    {{ $activity->name }}
                                </div>
                            @endforeach
                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>
@endsection
