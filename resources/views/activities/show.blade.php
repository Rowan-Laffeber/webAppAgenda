@extends('layouts.app')

@section('title', $activity->name)

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

        <div class="h-2" style="background-color: {{ $activity->color ?? $activity->agenda->color ?? '#6366f1' }}"></div>

        <div class="p-8">
            <h1 class="text-2xl font-bold text-slate-900">{{ $activity->name }}</h1>

            @php
                $start    = $activity->start_datetime;
                $end      = $activity->end_datetime;
                $multiDay = !$start->isSameDay($end);
            @endphp

            <div class="mt-5 flex items-start gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm"
                     style="background-color: {{ $activity->color ?? $activity->agenda->color ?? '#6366f1' }}">
                    &#9679;
                </div>
                <div>
                    @if($multiDay)
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $start->translatedFormat('l d F Y') }} {{ $start->format('H:i') }}
                        </p>
                        <p class="text-sm text-slate-500 mt-0.5">
                            t/m {{ $end->translatedFormat('l d F Y') }} {{ $end->format('H:i') }}
                        </p>
                    @else
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $start->translatedFormat('l d F Y') }}
                        </p>
                        <p class="text-sm text-slate-500 mt-0.5">
                            {{ $start->format('H:i') }} – {{ $end->format('H:i') }}
                        </p>
                    @endif
                </div>
            </div>

            @if($activity->description)
                <div class="mt-6">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Omschrijving</p>
                    <p class="text-slate-700 text-sm leading-relaxed">{{ $activity->description }}</p>
                </div>
            @endif

            <div class="mt-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Agenda</p>
                <div class="flex items-center gap-2 text-sm text-slate-700">
                    @if($activity->agenda->color)
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $activity->agenda->color }}"></div>
                    @endif
                    {{ $activity->agenda->name }}
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('activities.edit', $activity) }}"
                   class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-700 transition">
                    Bewerken
                </a>

                <form action="{{ route('activities.destroy', $activity) }}" method="POST"
                      onsubmit="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold hover:bg-red-100 transition">
                        Verwijderen
                    </button>
                </form>

                <a href="{{ route('agendas.show', $activity->agenda) }}"
                   class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-semibold hover:bg-slate-200 transition ml-auto">
                    ← Terug
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
