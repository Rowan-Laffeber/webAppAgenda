@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans selection:bg-indigo-500 selection:text-white">
    <div class="w-full max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 p-8 sm:p-12 border border-slate-100">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-6 mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Dashboard Placeholder Page</h1>
                <p class="text-sm font-medium text-slate-400 mt-2">Welkom back, {{ auth()->user()->name }}</p>
            </div>
            
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-xl hover:shadow-slate-900/20 focus:outline-none focus:ring-4 focus:ring-slate-900/20 transition duration-200 uppercase tracking-widest text-xs">
                    Logout
                </button>
            </form>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 min-h-[200px] flex items-center justify-center border-dashed">
            <p class="text-sm font-medium text-slate-400">Plaats hier de rest van de dashboard content</p>
        </div>

    </div>
</div>
@endsection
