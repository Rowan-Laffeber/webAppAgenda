@foreach($users as $user)

    <div class="flex justify-between items-center p-3 border-b">

        <span>{{ $user->name }}</span>

        @if($user->friend_status === 'none')

            <button
                class="send-request bg-blue-500 text-white px-3 py-1 rounded"
                data-user="{{ $user->id }}"
            >
                Add Friend
            </button>

        @elseif($user->friend_status === 'outgoing')

            <span class="text-gray-500 text-sm">Request sent</span>

        @elseif($user->friend_status === 'incoming')

            <span class="text-blue-500 text-sm">Wants to connect</span>

        @elseif($user->friend_status === 'friends')

            <span class="text-green-600 text-sm">Friends</span>

        @endif

    </div>

@endforeach