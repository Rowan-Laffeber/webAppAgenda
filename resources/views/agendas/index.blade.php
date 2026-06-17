@extends('layouts.app')

@section('title', 'Mijn agenda\'s')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

            <div class="flex items-center justify-between border-b border-slate-100 pb-6 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mijn agenda’s</h1>
                    <p class="text-sm font-medium text-slate-400 mt-2">Overzicht van al je agenda’s</p>
                </div>

                <a href="{{ route('agendas.create') }}"
                   class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg text-xs uppercase tracking-widest">
                    Nieuwe agenda
                </a>
            </div>

            <div class="grid gap-6">
                @foreach($agendas as $agenda)
                    <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50 hover:shadow-md transition">
                        <h2 class="text-xl font-bold text-slate-900">{{ $agenda->name }}</h2>
                        <p class="text-sm text-slate-500 mt-1">{{ $agenda->description }}</p>

                        <a href="{{ route('agendas.show', $agenda) }}"
                           class="inline-block mt-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                            Open →
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
