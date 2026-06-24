@foreach($users as $user)

    <div class="flex justify-between items-center p-3 border-b">

        <span>{{ $user->name }}</span>

        <button
            class="send-request bg-blue-500 text-white px-3 py-1 rounded"
            data-user="{{ $user->id }}"
        >
            Add Friend
        </button>

    </div>

@endforeach