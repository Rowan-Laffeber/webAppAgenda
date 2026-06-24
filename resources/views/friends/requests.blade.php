<h2 class="text-lg font-bold mb-4">Friend Requests</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- ========================= --}}
    {{-- INCOMING REQUESTS --}}
    {{-- ========================= --}}
    <div class="border rounded-xl p-4 bg-slate-50">

        <h3 class="font-semibold mb-3">Incoming</h3>

        <div class="space-y-2">

            @forelse($incomingRequests as $request)

                <div class="p-3 bg-white border rounded flex justify-between items-center">

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