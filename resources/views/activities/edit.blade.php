@extends('layouts.app')

@section('title', 'Activiteit bewerken')

@section('content')

    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

            ```
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Activiteit bewerken
                </h1>
                <p class="text-sm font-medium text-slate-400 mt-2">
                    Pas de gegevens van deze activiteit aan
                </p>
            </div>

            <form method="POST" action="{{ route('activities.update', $activity) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- agenda --}}
                <select name="agenda_id"
                        class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">

                    @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id }}"
                            {{ $activity->agenda_id == $agenda->id ? 'selected' : '' }}>
                            {{ $agenda->name }}
                        </option>
                    @endforeach

                </select>

                {{-- naam --}}
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $activity->name) }}"
                    placeholder="Naam van activiteit"
                    class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">

                {{-- omschrijving --}}
                <textarea
                    name="description"
                    placeholder="Omschrijving"
                    class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $activity->description) }}</textarea>

                {{-- datetime --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="text-xs font-semibold text-slate-500">
                            Start
                        </label>

                        <input
                            type="datetime-local"
                            name="start_datetime"
                            value="{{ \Carbon\Carbon::parse($activity->start_datetime)->format('Y-m-d\TH:i') }}"
                            class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-slate-500">
                            Einde
                        </label>

                        <input
                            type="datetime-local"
                            name="end_datetime"
                            value="{{ \Carbon\Carbon::parse($activity->end_datetime)->format('Y-m-d\TH:i') }}"
                            class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                </div>

                {{-- kleur --}}
                <div>
                    <label class="text-xs font-semibold text-slate-500">
                        Kleur
                    </label>

                    <input
                        type="color"
                        name="color"
                        value="{{ $activity->color }}"
                        class="w-full h-12 mt-1 rounded-xl border-slate-200">
                </div>

                {{-- buttons --}}
                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl">
                        Opslaan
                    </button>

                    <a href="{{ route('activities.show', $activity) }}"
                       class="px-6 py-3 bg-slate-200 rounded-xl text-slate-700 font-semibold">
                        Annuleren
                    </a>

                </div>

            </form>

        </div>
        ```

    </div>
@endsection
