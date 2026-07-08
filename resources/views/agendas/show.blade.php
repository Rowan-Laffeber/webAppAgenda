@extends('layouts.app')

@section('title', $agenda->name)

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-4 md:p-10 font-sans">
        <div class="w-full max-w-7xl mx-auto bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100">

            <div class="flex items-center justify-between px-8 py-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    @if($agenda->color)
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $agenda->color }}"></div>
                    @endif
                    <h1 class="text-2xl font-bold text-slate-900">{{ $agenda->name }}</h1>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('activities.create') }}"
                       class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-slate-700 transition">
                        + Activiteit
                    </a>
                    <a href="{{ route('agendas.edit', $agenda) }}"
                       class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-slate-200 transition">
                        Bewerken
                    </a>
                    <a href="{{ route('agendas.invite', $agenda) }}"
                       class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-slate-200 transition">
                        Uitnodigen
                    </a>
                    <form action="{{ route('agendas.destroy', $agenda) }}" method="POST"
                          onsubmit="return confirm('Weet je zeker dat je deze agenda wilt verwijderen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-semibold uppercase tracking-widest hover:bg-red-100 transition">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>

            @php
                use Carbon\Carbon;

                // Create link for view
                $buildUrl = function(array $params) use ($agenda, $view, $month, $year, $week, $day) {
                    return route('agendas.show', array_merge([
                        'agenda' => $agenda->id,
                        'view'   => $view,
                        'month'  => $month,
                        'year'   => $year,
                        'week'   => $week,
                        'day'    => $day,
                    ], $params));
                };

                // Check selected view
                switch ($view) {
                    // day view
                    case 'day':
                        $currentDay  = Carbon::create($year, $month, $day);
                        $prevUrl     = $buildUrl(['day' => $currentDay->copy()->subDay()->day, 'month' => $currentDay->copy()->subDay()->month, 'year' => $currentDay->copy()->subDay()->year]);
                        $nextUrl     = $buildUrl(['day' => $currentDay->copy()->addDay()->day, 'month' => $currentDay->copy()->addDay()->month, 'year' => $currentDay->copy()->addDay()->year]);
                        $periodLabel = $currentDay->translatedFormat('l d F Y');
                        break;
                    // week view
                    case 'week':
                        $weekStart   = Carbon::now()->setISODate($year, $week)->startOfWeek();
                        $weekEnd     = $weekStart->copy()->endOfWeek();
                        $prevWeek    = $weekStart->copy()->subWeek();
                        $nextWeek    = $weekStart->copy()->addWeek();
                        $prevUrl     = $buildUrl(['week' => $prevWeek->weekOfYear, 'year' => $prevWeek->year]);
                        $nextUrl     = $buildUrl(['week' => $nextWeek->weekOfYear, 'year' => $nextWeek->year]);
                        $periodLabel = $weekStart->format('d M') . ' – ' . $weekEnd->format('d M Y');
                        break;
                    // year view
                    case 'year':
                        $prevUrl     = $buildUrl(['year' => $year - 1]);
                        $nextUrl     = $buildUrl(['year' => $year + 1]);
                        $periodLabel = (string) $year;
                        break;
                    default:
                        $cur         = Carbon::create($year, $month, 1);
                        $prev        = $cur->copy()->subMonth();
                        $next        = $cur->copy()->addMonth();
                        $prevUrl     = $buildUrl(['month' => $prev->month, 'year' => $prev->year]);
                        $nextUrl     = $buildUrl(['month' => $next->month, 'year' => $next->year]);
                        $periodLabel = $cur->translatedFormat('F Y');
                        break;
                }
            @endphp

            <div class="flex items-center justify-between px-8 py-4 border-b border-slate-100 gap-4 flex-wrap">

                <div class="flex items-center gap-3">
                    <a href="{{ $prevUrl }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 transition text-slate-600 font-bold text-sm">
                        ‹
                    </a>
                    <span class="text-sm font-semibold text-slate-800 min-w-[160px] text-center">{{ $periodLabel }}</span>
                    <a href="{{ $nextUrl }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 transition text-slate-600 font-bold text-sm">
                        ›
                    </a>
                </div>

                <div class="flex rounded-lg overflow-hidden border border-slate-200 text-xs font-semibold uppercase tracking-wider">
                    @foreach(['day' => 'Dag', 'week' => 'Week', 'month' => 'Maand', 'year' => 'Jaar'] as $v => $label)
                        <a href="{{ $buildUrl(['view' => $v]) }}"
                           class="{{ $view === $v ? 'bg-slate-900 text-white' : 'bg-white text-slate-500 hover:bg-slate-50' }} px-4 py-2 transition border-r border-slate-200 last:border-0">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

            </div>

            <div class="p-4 md:p-6">
                {{-- show day view --}}
                @if($view === 'day')
                    @php
                        // Activities for this day
                        $dayActivities = $activities->sortBy('start_datetime');
                    @endphp

                    <div class="space-y-2 max-w-2xl mx-auto">
                        @forelse($dayActivities as $act)
                            @php
                                $spansDays = !$act->start_datetime->isSameDay($act->end_datetime);
                            @endphp
                            <a href="{{ route('activities.show', $act) }}"
                               class="flex items-start gap-4 rounded-xl px-5 py-4 text-white hover:opacity-90 transition"
                               style="background-color: {{ $act->color ?? $act->agenda->color ?? '#6366f1' }}">
                                <div class="text-xs font-bold opacity-80 whitespace-nowrap pt-0.5">
                                    {{ $act->start_datetime->format('H:i') }}<br>
                                    {{ $act->end_datetime->format('H:i') }}
                                </div>
                                <div>
                                    <div class="font-semibold text-sm">{{ $act->name }}</div>
                                    @if($spansDays)
                                        <div class="text-[11px] opacity-75 mt-0.5">
                                            t/m {{ $act->end_datetime->format('d M') }}
                                        </div>
                                    @endif
                                    @if($act->description)
                                        <div class="text-xs opacity-70 mt-1 line-clamp-2">{{ $act->description }}</div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-slate-400 text-sm py-12">Geen activiteiten op deze dag.</p>
                        @endforelse
                    </div>
                    {{-- show week view --}}
                @elseif($view === 'week')
                    @php
                        // Create the days for this week
                        $weekStart = Carbon::now()->setISODate($year, $week)->startOfWeek();
                        $weekDays  = collect();
                        for ($d = $weekStart->copy(); $weekDays->count() < 7; $d->addDay()) {
                            $weekDays->push($d->copy());
                        }
                    @endphp

                    <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        @foreach($weekDays as $wd)
                            <div class="{{ $wd->isToday() ? 'text-indigo-600' : '' }}">
                                {{ $wd->format('D') }}<br>
                                <span class="text-base font-extrabold {{ $wd->isToday() ? 'text-indigo-600' : 'text-slate-700' }}">
                                {{ $wd->format('d') }}
                            </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1 min-h-[400px]">
                        @foreach($weekDays as $wd)
                            @php
                                // Get activities for this day
                                $dayActs = $activities->filter(function($a) use ($wd) {
                                    return $a->start_datetime->lte($wd->copy()->endOfDay())
                                        && $a->end_datetime->gte($wd->copy()->startOfDay());
                                })->sortBy('start_datetime');
                            @endphp

                            <div class="border border-slate-100 rounded-xl p-1.5 {{ $wd->isToday() ? 'bg-indigo-50/50' : 'bg-slate-50' }} min-h-[120px]">
                                <div class="space-y-1">
                                    @foreach($dayActs as $act)
                                        @php
                                            $startsToday = $act->start_datetime->isSameDay($wd);
                                            $endsToday   = $act->end_datetime->isSameDay($wd);
                                        @endphp
                                        <a href="{{ route('activities.show', $act) }}"
                                           class="block rounded-lg px-2 py-1 text-white hover:opacity-90 transition"
                                           style="background-color: {{ $act->color ?? $act->agenda->color ?? '#6366f1' }}">
                                            <div class="text-[10px] font-bold truncate">{{ $act->name }}</div>
                                            <div class="text-[9px] opacity-80">
                                                @if($startsToday){{ $act->start_datetime->format('H:i') }}@else&rsaquo;@endif
                                                –
                                                @if($endsToday){{ $act->end_datetime->format('H:i') }}@else&rsaquo;@endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- show year view --}}
                @elseif($view === 'year')
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @for($m = 1; $m <= 12; $m++)
                            @php
                                $mStart   = Carbon::create($year, $m, 1);
                                $mEnd     = $mStart->copy()->endOfMonth();
                                $mActs    = $activities->filter(function($a) use ($mStart, $mEnd) {
                                    return $a->start_datetime->lte($mEnd)
                                        && $a->end_datetime->gte($mStart);
                                });
                            @endphp

                            <a href="{{ $buildUrl(['view' => 'month', 'month' => $m, 'year' => $year]) }}"
                               class="border border-slate-100 rounded-xl p-4 hover:shadow-md transition bg-white group">
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 group-hover:text-indigo-600 transition">
                                    {{ $mStart->translatedFormat('F') }}
                                </div>
                                <div class="space-y-1">
                                    @foreach($mActs->take(3) as $act)
                                        <div class="h-1.5 rounded-full w-full"
                                             style="background-color: {{ $act->color ?? $act->agenda->color ?? '#6366f1' }}">
                                        </div>
                                    @endforeach
                                    @if($mActs->count() > 3)
                                        <div class="text-[10px] text-slate-400">+{{ $mActs->count() - 3 }} meer</div>
                                    @endif
                                    @if($mActs->isEmpty())
                                        <div class="text-[10px] text-slate-300">Geen activiteiten</div>
                                    @endif
                                </div>
                                <div class="text-[11px] font-semibold text-slate-500 mt-2">{{ $mActs->count() }} activiteit{{ $mActs->count() !== 1 ? 'en' : '' }}</div>
                            </a>
                        @endfor
                    </div>

                {{-- Show month view --}}
                @else
                    <div class="grid grid-cols-7 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        @foreach(['Ma','Di','Wo','Do','Vr','Za','Zo'] as $dayName)
                            <div>{{ $dayName }}</div>
                        @endforeach
                    </div>

                    @php
                        $startOfMonth = $days->first();
                        // Count empty cells before the first day
                        $emptyCells   = $startOfMonth->copy()->startOfMonth()->dayOfWeekIso - 1;
                    @endphp

                    <div class="grid grid-cols-7 gap-1">

                        @for($i = 0; $i < $emptyCells; $i++)
                            <div></div>
                        @endfor

                        @foreach($days as $day)
                            @php
                                $dayActs = $activities->filter(function($a) use ($day) {
                                    return $a->start_datetime->lte($day->copy()->endOfDay())
                                        && $a->end_datetime->gte($day->copy()->startOfDay());
                                })->sortBy('start_datetime');

                                $isToday = $day->isToday();
                            @endphp

                            <a href="{{ $buildUrl(['view' => 'day', 'day' => $day->day, 'month' => $day->month, 'year' => $day->year]) }}"
                               class="min-h-[90px] border border-slate-100 rounded-xl p-1.5 transition hover:border-indigo-200 hover:shadow-sm {{ $isToday ? 'bg-indigo-50/60 border-indigo-200' : 'bg-slate-50' }}">

                                <div class="text-[11px] font-bold {{ $isToday ? 'text-indigo-600' : 'text-slate-400' }} mb-1">
                                    {{ $day->format('d') }}
                                </div>

                                <div class="space-y-0.5">
                                    {{-- Show max 3 activities --}}
                                    @foreach($dayActs->take(3) as $act)
                                        @php
                                            $startsToday = $act->start_datetime->isSameDay($day);
                                            $endsToday   = $act->end_datetime->isSameDay($day);
                                        @endphp
                                        <div class="rounded px-1.5 py-0.5 text-white"
                                             style="background-color: {{ $act->color ?? $act->agenda->color ?? '#6366f1' }}">
                                            <div class="text-[9px] font-bold truncate">{{ $act->name }}</div>
                                            <div class="text-[8px] opacity-80">
                                                @if($startsToday){{ $act->start_datetime->format('H:i') }}@else&lsaquo;@endif
                                                –
                                                @if($endsToday){{ $act->end_datetime->format('H:i') }}@else&rsaquo;@endif
                                            </div>
                                        </div>
                                    @endforeach

                                    @if($dayActs->count() > 3)
                                        <div class="text-[9px] text-slate-400 pl-1">+{{ $dayActs->count() - 3 }} meer</div>
                                    @endif
                                </div>

                            </a>
                        @endforeach

                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
