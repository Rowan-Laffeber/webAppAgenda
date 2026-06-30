@extends('layouts.app')

@section('title', "Mijn agenda's")

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
    <div class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">

        <div class="flex items-center justify-between border-b border-slate-100 pb-6 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Mijn agenda's</h1>
                <p class="text-sm text-slate-400 mt-1">Overzicht van al je agenda's</p>
            </div>
            <a href="{{ route('agendas.create') }}"
               class="bg-slate-900 hover:bg-slate-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs uppercase tracking-widest transition">
                + Nieuwe agenda
            </a>
        </div>

        <div class="grid gap-4">
            @forelse($agendas as $agenda)
                <div class="border border-slate-100 rounded-xl p-5 bg-slate-50 hover:shadow-md transition flex items-center gap-4">
                    <div class="w-3 h-10 rounded-full flex-shrink-0"
                         style="background-color: {{ $agenda->color ?? '#6366f1' }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-base font-bold text-slate-900">{{ $agenda->name }}</h2>
                        @if($agenda->description)
                            <p class="text-sm text-slate-500 mt-0.5 truncate">{{ $agenda->description }}</p>
                        @endif
                    </div>
                    <a href="{{ route('agendas.show', $agenda) }}"
                       class="text-xs font-bold uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition flex-shrink-0">
                        Open →
                    </a>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm py-10">Je hebt nog geen agenda's. Maak er een aan!</p>
            @endforelse
        </div>

    </div>
</div>
@endsection
