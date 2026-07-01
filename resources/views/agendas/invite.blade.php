@extends('layouts.app')

@section('title', 'Vrienden uitnodigen')

@section('content')
    <div class="bg-slate-50 p-6 md:p-12 font-sans">
        <div class="max-w-2xl mx-auto">

            <div class="mb-6 flex items-center gap-3">
                <a href="{{ route('agendas.show', $agenda) }}"
                   class="text-slate-400 hover:text-slate-700 transition text-lg">←</a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Vrienden uitnodigen</h1>
                    <p class="text-sm text-slate-400 mt-0.5">
                        Voor agenda:
                        <span class="font-semibold" style="color: {{ $agenda->color ?? '#6366f1' }}">
                        {{ $agenda->name }}
                    </span>
                    </p>
                </div>
            </div>

            <div id="feedback" class="hidden mb-4 px-4 py-3 rounded-xl text-sm font-semibold border"></div>

            <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
                @if($friends->isEmpty())
                    <div class="px-8 py-16 text-center text-slate-400 text-sm">
                        Je hebt nog geen vrienden om uit te nodigen.
                    </div>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach($friends as $friend)
                            @php $invited = $invitedIds->contains($friend->id); @endphp
                            <li class="flex items-center justify-between px-6 py-4 gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center text-sm font-bold text-slate-600 flex-shrink-0">
                                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $friend->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $friend->email }}</p>
                                    </div>
                                </div>

                                @if($invited)
                                    <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg flex-shrink-0">
                                    Uitgenodigd
                                </span>
                                @else
                                    <button onclick="invite({{ $friend->id }}, this)"
                                            class="text-xs font-semibold text-white px-4 py-1.5 rounded-lg flex-shrink-0 transition hover:opacity-80"
                                            style="background-color: {{ $agenda->color ?? '#6366f1' }}">
                                        Uitnodigen
                                    </button>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function invite(friendId, btn) {
            btn.disabled = true;
            btn.textContent = '...';

            fetch('/agenda/{{ $agenda->id }}/invite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ receiver_id: friendId })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        btn.textContent = 'Uitgenodigd';
                        btn.disabled = true;
                        btn.className = 'text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg flex-shrink-0';
                        btn.removeAttribute('style');
                        showFeedback('Uitnodiging verstuurd!', 'green');
                    } else {
                        btn.textContent = 'Uitnodigen';
                        btn.disabled = false;
                        showFeedback(data.message, 'red');
                    }
                })
                .catch(() => {
                    btn.textContent = 'Uitnodigen';
                    btn.disabled = false;
                    showFeedback('Er ging iets mis, probeer opnieuw.', 'red');
                });
        }

        function showFeedback(message, color) {
            const el = document.getElementById('feedback');
            el.textContent = message;
            el.className = color === 'green'
                ? 'mb-4 px-4 py-3 rounded-xl text-sm font-semibold border bg-green-50 text-green-700 border-green-200'
                : 'mb-4 px-4 py-3 rounded-xl text-sm font-semibold border bg-red-50 text-red-700 border-red-200';
            el.classList.remove('hidden');
            setTimeout(() => el.classList.add('hidden'), 3000);
        }
    </script>
@endsection
