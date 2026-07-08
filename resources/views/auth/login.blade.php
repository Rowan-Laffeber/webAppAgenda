@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-6 md:p-12 font-sans selection:bg-indigo-500 selection:text-white">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 overflow-hidden flex flex-col md:flex-row min-h-[540px] border border-slate-100">

        <div class="relative w-full md:w-1/2 h-56 md:h-auto overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900" style="clip-path: url(#wireframe-curve);">
            <img
                src="https://githubusercontent.com"
                alt="Laravel Logo"
                class="absolute inset-0 w-3/5 h-auto m-auto object-contain opacity-25 p-8"
            />
            <div class="absolute top-[-20%] left-[-20%] w-72 h-72 bg-indigo-500 rounded-full blur-[100px] opacity-20"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-72 h-72 bg-emerald-500 rounded-full blur-[100px] opacity-10"></div>
        </div>

        <div class="w-full md:w-1/2 p-8 sm:p-12 md:p-16 flex flex-col justify-center">
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">LOGIN</h2>
                <p class="text-sm font-medium text-slate-400 mt-2">Welkom terug! Log in op je account</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 rounded-xl border border-rose-100 text-sm text-rose-600">
                    @error('email')
                        {{ $message }}
                    @else
                        Controleer de gemarkeerde velden hieronder.
                    @enderror
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div class="space-y-1">
                    <label for="email" class="sr-only">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email"
                        required
                        class="w-full px-5 py-3.5 bg-slate-50 border @error('email') border-rose-400 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium"
                    />
                </div>

                <div class="space-y-1">
                    <label for="password" class="sr-only">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        required
                        class="w-full px-5 py-3.5 bg-slate-50 border @error('email') border-rose-400 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium"
                    />
                </div>

                <div class="pt-3">
                    <button
                        type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-xl hover:shadow-slate-900/20 focus:outline-none focus:ring-4 focus:ring-slate-900/20 transition duration-200 uppercase tracking-widest text-xs"
                    >
                        login
                    </button>
                </div>
            </form>

            <!-- Optionele link naar registratie -->
            <div class="mt-8 text-center md:text-left">
                <p class="text-sm text-slate-500">
                    Nog geen account?
                    <a href="/register" class="text-indigo-600 hover:text-indigo-500 font-semibold transition duration-150">Registreer hier</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Perfect werkende SVG-clip met de juiste XML-namespaces voor vlekkeloze browser-rendering -->
<svg class="absolute w-0 h-0" width="0" height="0" version="1.1" xmlns="http://w3.org">
    <defs>
        <clipPath id="wireframe-curve" clipPathUnits="objectBoundingBox">
            <path d="M 0,0 L 1,0 Q 0.86,0.5 1,1 L 0,1 Z" />
        </clipPath>
    </defs>
</svg>
@endsection
