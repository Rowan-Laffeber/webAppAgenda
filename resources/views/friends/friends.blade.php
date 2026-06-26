<h2 class="text-lg font-bold mb-4">My Friends</h2>

<div class="mb-4">
    <input
        type="text"
        id="friend-search"
        placeholder="Search friends..."
        class="w-full p-3 border rounded-xl"
    >
</div>

<div id="friends-list" class="space-y-2">

    @include('friends.friends-list', ['friends' => $friends])

</div>
<script>
document.addEventListener('input', function (e) {

    if (e.target.id !== 'friend-search') return;

    fetch(`/friends/search?search=${e.target.value}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('friends-list').innerHTML = html;
        });

});
</script>