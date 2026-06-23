@foreach($users as $user)

    <div class="p-3 border-b">
        {{ $user->name }}
    </div>

@endforeach