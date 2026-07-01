<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Agenda App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

 {{-- Reusable header --}}
 @if(!request()->is('login', 'register'))
    @include('partials.header')
@endif

<main class="max-w-7xl mx-auto p-6">
    @yield('content') {{-- Page-specific content goes here --}}
</main>
{{-- Reusable footer --}}
@if(!request()->is('login', 'register'))
    @include('partials.footer')
@endif

@yield('scripts') {{-- Page-specific scripts go here --}}

</body>
</html>
