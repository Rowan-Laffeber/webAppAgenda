<h2 class="text-lg font-bold mb-4">Friend Requests</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- ========================= --}}
    {{-- INCOMING REQUESTS --}}
    {{-- ========================= --}}
    <div class="border rounded-xl p-4 bg-slate-50">

        <h3 class="font-semibold mb-3">Incoming</h3>

        <div class="space-y-2">

            @forelse($incomingRequests as $request)

                <div
                    class="incoming-request p-3 bg-white border rounded flex justify-between items-center cursor-pointer hover:bg-slate-100 transition"
                    data-id="{{ $request->id }}"
                    data-name="{{ $request->sender->name }}"
                >

                    <span class="font-medium">
                        {{ $request->sender->name }}
                    </span>

                    <span class="text-xs text-blue-600 font-medium">
                        Wants to connect
                    </span>

                </div>

            @empty

                <div class="text-slate-500 text-sm">
                    No incoming requests
                </div>

            @endforelse

        </div>

    </div>

    {{-- ========================= --}}
    {{-- OUTGOING REQUESTS --}}
    {{-- ========================= --}}
    <div class="border rounded-xl p-4 bg-slate-50">

        <h3 class="font-semibold mb-3">Outgoing</h3>

        <div class="space-y-2">

            @forelse($outgoingRequests as $request)

                <div class="p-3 bg-white border rounded flex justify-between items-center">

                    <span class="font-medium">
                        {{ $request->receiver->name }}
                    </span>

                    <span class="text-xs text-slate-500">
                        Request sent
                    </span>

                </div>

            @empty

                <div class="text-slate-500 text-sm">
                    No outgoing requests
                </div>

            @endforelse

        </div>

    </div>

</div>

{{-- ========================= --}}
{{-- REQUEST POPUP --}}
{{-- ========================= --}}
<div
    id="request-modal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50"
>

    <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6">

        <h2 class="text-xl font-bold mb-2">
            Friend Request
        </h2>

        <p class="text-slate-600 mb-6">
            <span id="request-name" class="font-semibold"></span>
            wants to connect with you.
        </p>

        <div class="flex justify-end gap-3">

            <button
                id="close-modal"
                class="px-4 py-2 rounded border hover:bg-slate-100"
            >
                Cancel
            </button>

            <button
                id="decline-btn"
                class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600"
            >
                Decline
            </button>

            <button
                id="accept-btn"
                class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700"
            >
                Accept
            </button>

        </div>

    </div>

</div>

<script>

let currentRequestId = null;

const modal = document.getElementById('request-modal');
const requestName = document.getElementById('request-name');

document.addEventListener('click', function (event) {

    const card = event.target.closest('.incoming-request');

    if (!card) return;

    currentRequestId = card.dataset.id;

    requestName.textContent = card.dataset.name;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

});

function closeModal() {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

document.getElementById('close-modal').addEventListener('click', closeModal);

modal.addEventListener('click', function (event) {

    if (event.target === modal) {
        closeModal();
    }

});

document.getElementById('accept-btn').addEventListener('click', function () {

    fetch(`/friends/request/${currentRequestId}/accept`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(() => location.reload());

});

document.getElementById('decline-btn').addEventListener('click', function () {

    fetch(`/friends/request/${currentRequestId}/decline`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(() => location.reload());

});

</script>