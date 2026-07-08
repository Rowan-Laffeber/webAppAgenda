@extends('layouts.app')

@section('title', 'Agenda uitnodigingen')

@section('content')
<div class="bg-slate-50 p-6 md:p-12 font-sans">
    <div class="max-w-4xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Agenda uitnodigingen</h1>
            <p class="text-sm text-slate-400 mt-1">Bekijk en beheer je agenda uitnodigingen</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="border rounded-xl p-4 bg-slate-50">
                <h3 class="font-semibold mb-3">Ontvangen</h3>

                <div class="space-y-2">
                    @forelse($incoming as $invitation)
                        <div class="incoming-invitation p-3 bg-white border rounded-lg flex justify-between items-center cursor-pointer hover:bg-slate-100 transition"
                             data-id="{{ $invitation->id }}"
                             data-name="{{ $invitation->sender->name }}"
                             data-agenda="{{ $invitation->agenda->name }}">
                            <div>
                                <p class="font-medium text-sm">{{ $invitation->agenda->name }}</p>
                                <p class="text-xs text-slate-400">van {{ $invitation->sender->name }}</p>
                            </div>
                            <span class="text-xs text-indigo-600 font-medium">Uitnodiging</span>
                        </div>
                    @empty
                        <div class="text-slate-500 text-sm">Geen uitnodigingen</div>
                    @endforelse
                </div>
            </div>

            <div class="border rounded-xl p-4 bg-slate-50">
                <h3 class="font-semibold mb-3">Verstuurd</h3>

                <div class="space-y-2">
                    @forelse($outgoing as $invitation)
                        <div class="p-3 bg-white border rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-medium text-sm">{{ $invitation->agenda->name }}</p>
                                <p class="text-xs text-slate-400">naar {{ $invitation->receiver->name }}</p>
                            </div>
                            <span class="text-xs text-slate-400">
                                {{ $invitation->invitation_status === 'accepted' ? '✓ Geaccepteerd' : ($invitation->invitation_status === 'declined' ? '✗ Geweigerd' : 'Wacht op antwoord') }}
                            </span>
                        </div>
                    @empty
                        <div class="text-slate-500 text-sm">Geen verstuurde uitnodigingen</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

<div id="invite-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6">
        <h2 class="text-xl font-bold mb-2">Agenda uitnodiging</h2>
        <p class="text-slate-600 mb-6">
            <span id="invite-sender" class="font-semibold"></span>
            nodigt je uit voor agenda
            <span id="invite-agenda" class="font-semibold"></span>.
        </p>
        <div class="flex justify-end gap-3">
            <button id="close-modal" class="px-4 py-2 rounded border hover:bg-slate-100 text-sm">
                Annuleren
            </button>
            <button id="decline-btn" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600 text-sm">
                Weigeren
            </button>
            <button id="accept-btn" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 text-sm">
                Accepteren
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentInviteId = null;
    const modal = document.getElementById('invite-modal');

    document.addEventListener('click', function(e) {
        const card = e.target.closest('.incoming-invitation');
        if (!card) return;
        currentInviteId = card.dataset.id;
        document.getElementById('invite-sender').textContent = card.dataset.name;
        document.getElementById('invite-agenda').textContent = card.dataset.agenda;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    function closeModal() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    document.getElementById('close-modal').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });

    document.getElementById('accept-btn').addEventListener('click', function() {
        fetch(`/invitations/${currentInviteId}/accept`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    });

    document.getElementById('decline-btn').addEventListener('click', function() {
        fetch(`/invitations/${currentInviteId}/decline`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    });
</script>
@endsection
