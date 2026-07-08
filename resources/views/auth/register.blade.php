@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div class="h-screen w-screen bg-slate-50 flex items-center justify-center p-4 md:p-8 font-sans selection:bg-indigo-500 selection:text-white overflow-hidden">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 overflow-hidden flex flex-col md:flex-row min-h-[540px] max-h-[90vh] border border-slate-100">

        <div class="relative w-full md:w-1/2 h-44 md:h-auto overflow-hidden bg-gradient-to-br from-indigo-950 via-indigo-900 to-slate-900 flex-shrink-0" style="clip-path: url(#wireframe-curve);">
            <img
                src="https://githubusercontent.com"
                alt="Laravel Logo"
                class="absolute inset-0 w-3/5 h-auto m-auto object-contain opacity-25 p-8"
            />
            <div class="absolute top-[-20%] left-[-20%] w-72 h-72 bg-indigo-500 rounded-full blur-[100px] opacity-20"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-72 h-72 bg-emerald-500 rounded-full blur-[100px] opacity-10"></div>
        </div>

        <div class="w-full md:w-1/2 p-6 sm:p-10 md:p-12 flex flex-col justify-center overflow-y-auto">
            <div class="mb-6 text-center md:text-left">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">REGISTER</h2>
                <p class="text-sm font-medium text-slate-400 mt-1">Maak snel en eenvoudig je account aan</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-rose-50 rounded-xl border border-rose-100 text-xs text-rose-600">
                    Controleer de gemarkeerde velden hieronder.
                </div>
            @endif

            <form method="POST" action="/register" class="space-y-4">
                @csrf

                <div class="space-y-1">
                    <label for="name" class="sr-only">Username</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="username"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border @error('name') border-rose-400 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium text-sm"
                    />
                    @error('name')
                        <span class="text-xs font-semibold text-rose-500 block px-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="email" class="sr-only">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border @error('email') border-rose-400 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium text-sm"
                    />
                    @error('email')
                        <span class="text-xs font-semibold text-rose-500 block px-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="sr-only">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border @error('password') border-rose-400 focus:ring-rose-500/20 focus:border-rose-500 @else border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 @enderror rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium text-sm"
                    />
                    @error('password')
                        <span class="text-xs font-semibold text-rose-500 block px-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="sr-only">Repeat Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="repeat password"
                        required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 focus:ring-indigo-500/20 focus:border-indigo-500 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition duration-200 font-medium text-sm"
                    />
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 active:bg-slate-950 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-xl hover:shadow-slate-900/20 focus:outline-none focus:ring-4 focus:ring-slate-900/20 transition duration-200 uppercase tracking-widest text-xs"
                    >
                        register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center md:text-left">
                <p class="text-xs text-slate-500">
                    Heb je al een account?
                    <a href="/login" class="text-indigo-600 hover:text-indigo-500 font-semibold transition duration-150">Log hier in</a>
                </p>
            </div>
        </div>
    </div>
</div>

<svg class="absolute w-0 h-0 opacity-0 pointer-events-none" version="1.1" xmlns="http://w3.org">
    <defs>
        <clipPath id="wireframe-curve" clipPathUnits="objectBoundingBox">
            <path d="M 0,0 L 1,0 Q 0.86,0.5 1,1 L 0,1 Z" />
        </clipPath>
    </defs>
</svg>
@endsection
