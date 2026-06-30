@extends('layouts.app')

@section('title', 'Agenda bewerken')

@section('content')

    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

            ```
            <div class="border-b border-slate-100 pb-6 mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Agenda bewerken
                </h1>
                <p class="text-sm font-medium text-slate-400 mt-2">
                    Pas de gegevens van deze agenda aan
                </p>
            </div>

            <form method="POST" action="{{ route('agendas.update', $agenda) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-xs font-semibold text-slate-500">
                        Naam
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $agenda->name) }}"
                        placeholder="Naam van agenda"
                        class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-500">
                        Omschrijving
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        placeholder="Omschrijving"
                        class="w-full mt-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $agenda->description) }}</textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-500">
                        Kleur
                    </label>

                    <input
                        type="color"
                        name="color"
                        value="{{ old('color', $agenda->color) }}"
                        class="w-full h-12 mt-1 rounded-xl border-slate-200">
                </div>

                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl">
                        Opslaan
                    </button>

                    <a href="{{ route('agendas.show', $agenda) }}"
                       class="px-6 py-3 bg-slate-200 rounded-xl text-slate-700 font-semibold">
                        Annuleren
                    </a>

                </div>

            </form>

        </div>
        ```

    </div>

@endsection
