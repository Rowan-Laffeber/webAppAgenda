@forelse($friends as $friend)

    <div class="p-3 border rounded-xl bg-slate-50 flex justify-between items-center">
        <span class="font-medium">
            {{ $friend->friend->name }}
        </span>
    </div>

@empty

    <div class="text-slate-500 text-sm">
        No friends found
    </div>

@endforelse