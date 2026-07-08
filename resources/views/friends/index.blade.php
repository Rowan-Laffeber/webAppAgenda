@extends('layouts.app')

@section('title', 'Friends')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 p-6 md:p-12">

    <div class="max-w-6xl mx-auto bg-white rounded-3xl border shadow flex overflow-hidden">

        <div class="w-64 bg-slate-50 border-r p-4 flex flex-col gap-2">

            <a href="?tab=requests"
               class="px-4 py-3 rounded-xl bg-white border text-sm font-bold">
                Friend Requests
            </a>

            <a href="?tab=friends"
               class="px-4 py-3 rounded-xl bg-white border text-sm font-bold">
                Friends
            </a>

            <a href="?tab=users"
               class="px-4 py-3 rounded-xl bg-white border text-sm font-bold">
                Find Users
            </a>

        </div>

        <div class="flex-1 p-6">

            @if(request('tab') === 'requests')
                @include('friends.requests')
            @endif

            @if(request('tab') === 'friends')
                @include('friends.friends')
            @endif

            @if(request('tab') === 'users')
                @include('friends.users')
            @endif

        </div>

    </div>

</div>
@endsection
