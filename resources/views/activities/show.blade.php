@extends('layouts.app')

@section('title', $activity->name)

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl p-8">

            <h1 class="text-3xl font-bold text-slate-900">
                {{ $activity->name }}
            </h1>

            <div class="mt-6 space-y-4">

                <div>
                    <p class="text-xs text-slate-500">Omschrijving</p>
                    <p>{{ $activity->description }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Start</p>
                    <p>{{ $activity->start_datetime }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Einde</p>
                    <p>{{ $activity->end_datetime }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Kleur</p>
                    <div class="w-8 h-8 rounded-full border"
                         style="background-color: {{ $activity->color }}">
                    </div>
                </div>

            </div>

            <div class="flex gap-3 mt-8">

                <a href="{{ route('activities.edit', $activity) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-xl">
                    Bewerken
                </a>

                <form action="{{ route('activities.destroy', $activity) }}"
                      method="POST"
                      onsubmit="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl">
                        Verwijderen
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
