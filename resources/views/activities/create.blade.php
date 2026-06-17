@extends('layouts.app')

@section('title', 'Activiteit aanmaken')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

            <div class="border-b border-slate-100 pb-6 mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Activiteit aanmaken
                </h1>
                <p class="text-sm font-medium text-slate-400 mt-2">
                    Voeg een nieuwe activiteit toe aan je agenda
                </p>
            </div>

            <form method="POST" action="{{ route('activities.store') }}" class="space-y-5">
                @csrf

                {{-- agenda --}}
                <select name="agenda_id"
                        class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id }}">
                            {{ $agenda->name }}
                        </option>
                    @endforeach
                </select>

                {{-- naam --}}
                <input type="text" name="name" placeholder="Naam van activiteit"
                       class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">

                {{-- omschrijving --}}
                <textarea name="description" placeholder="Omschrijving"
                          class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"></textarea>

                {{-- datetime --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-500">Start</label>
                        <input type="datetime-local" name="start_datetime"
                               class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500">Einde</label>
                        <input type="datetime-local" name="end_datetime"
                               class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                {{-- kleur --}}
                <div>
                    <label class="text-xs font-semibold text-slate-500">Kleur</label>
                    <input type="color" name="color"
                           class="w-full h-12 mt-1 rounded-xl border-slate-200">
                </div>

                {{-- submit --}}
                <button type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-xl transition duration-200 uppercase tracking-widest text-xs">
                    Opslaan
                </button>

            </form>

        </div>
    </div>
@endsection
