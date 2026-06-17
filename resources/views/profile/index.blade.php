@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
        <div class="w-full max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 border border-slate-100 flex flex-col md:flex-row overflow-hidden">

            {{-- ZIJBALK (NAVIGATION) --}}
            <div class="w-full md:w-64 bg-slate-50 border-b md:border-b-0 md:border-r border-slate-100 p-4 flex flex-col gap-2">
                <a href="#" class="w-full bg-slate-900 text-white px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest text-center md:text-left transition-colors">
                    My Profile
                </a>
                
                <a href="{{ route('agendas.index') }}" class="w-full bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest text-center md:text-left transition-colors">
                    My Agendas
                </a>
            </div>

            {{-- INHOUD (MAIN CONTENT) --}}
            <div class="flex-1 p-6 md:p-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- LINKER KOLOM: PROFIELGEGEVENS --}}
                    <div class="space-y-6">
                        
                        {{-- Avatar & Naam --}}
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                            {{-- Profile Picture Placeholder (De cirkel met het kruis) --}}
                            <div class="relative w-24 h-24 rounded-full border-2 border-slate-300 bg-slate-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                                <svg class="absolute w-full h-full text-slate-300" viewBox="0 0 100 100" stroke="currentColor" stroke-width="1.5">
                                    <line x1="0" y1="0" x2="100" y2="100" />
                                    <line x1="100" y1="0" x2="0" y2="100" />
                                </svg>
                            </div>
                            
                            {{-- Naam Veld --}}
                            <div class="w-full">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Naam</label>
                                <div class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-medium">
                                    {{ Auth::user()->name ?? 'Je Naam Hier' }}
                                </div>
                            </div>
                        </div>

                        {{-- Email Veld --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-medium truncate">
                                {{ Auth::user()->email ?? 'je.email@voorbeeld.nl' }}
                            </div>
                        </div>

                        {{-- Actie Knoppen Links --}}
                        <div class="flex flex-col gap-3 pt-4">
                            <a href="#" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm font-semibold text-center transition-colors">
                                Wijzig Wachtwoord
                            </a>
                            
                            <a href="#" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-semibold text-center transition-colors">
                                Bewerk Gegevens
                            </a>
                        </div>

                    </div>

                    {{-- RECHTER KOLOM: INSTELLINGEN --}}
                    <div class="space-y-6">
                        
                        <div>
                            <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest mb-4 pb-2 border-b border-slate-100">
                                Settings
                            </h2>
                        </div>

                        {{-- Darkmode Switch --}}
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            <span class="text-sm font-semibold text-slate-700">Darkmode / Lightmode</span>
                            <button type="button" class="bg-slate-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>

                        {{-- Secondary Color Picker Placeholder --}}
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                            <span class="text-sm font-semibold text-slate-700">Secondary Color</span>
                            <div class="w-6 h-6 rounded-md bg-indigo-600 border border-slate-300 shadow-sm cursor-pointer"></div>
                        </div>

                        {{-- Account Verwijderen --}}
                        <div class="pt-8">
                            <form action="#" method="POST" onsubmit="return confirm('Weet je zeker dat je jouw account wilt verwijderen? Dit kan niet ongedaan worden gemaakt.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-3 rounded-xl text-sm font-semibold text-center transition-colors border border-red-100">
                                    Delete Account
                                </button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
