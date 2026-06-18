@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12 font-sans">
    <div class="w-full max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl shadow-indigo-100/50 border border-slate-100 flex flex-col md:flex-row overflow-hidden">

        {{-- SIDEBAR --}}
        <div class="w-full md:w-64 bg-slate-50 border-b md:border-b-0 md:border-r border-slate-100 p-4 flex flex-col gap-2">

            <a href="{{ route('profile.index') }}"
               class="w-full bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest text-center md:text-left">
                My Profile
            </a>

            <a href="{{ route('agendas.index') }}"
               class="w-full bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-widest text-center md:text-left">
                My Agendas
            </a>

        </div>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 p-6 md:p-8">

            {{-- ERRORS --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- PROFILE INFO --}}
                <div class="space-y-4">

                    <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                        Profile Information
                    </h2>

                    {{-- NAME --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                            Naam
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                </div>

                {{-- PASSWORD SECTION --}}
                <div class="space-y-4 pt-6 border-t border-slate-100">

                    <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                        Change Password (optional)
                    </h2>

                    {{-- CURRENT PASSWORD --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                            Current Password
                        </label>

                        <input type="password"
                               name="current_password"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- NEW PASSWORD --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                            New Password
                        </label>

                        <input type="password"
                               name="new_password"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                            Confirm New Password
                        </label>

                        <input type="password"
                               name="new_password_confirmation"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="flex flex-col gap-3 pt-6">

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-semibold">
                        Save Changes
                    </button>

                    <a href="{{ route('profile.index') }}"
                       class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm font-semibold text-center">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>
</div>
@endsection