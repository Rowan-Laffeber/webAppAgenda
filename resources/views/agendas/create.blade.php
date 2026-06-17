@extends('layouts.app')

@section('title', 'Agenda aanmaken')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

            <div class="border-b border-slate-100 pb-6 mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Agenda aanmaken</h1>
                <p class="text-sm font-medium text-slate-400 mt-2">Maak een nieuwe agenda aan</p>
            </div>

            <form action="{{ route('agendas.store') }}" method="POST" class="space-y-5">
                @csrf

                <input type="text" name="name" placeholder="Naam"
                       class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">

                <textarea name="description" placeholder="Omschrijving"
                          class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"></textarea>

                <input type="color" name="color"
                       class="w-full h-12 rounded-xl border-slate-200">

                <button type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg">
                    Opslaan
                </button>
            </form>

        </div>
    </div>
@endsection
