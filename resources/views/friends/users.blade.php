<h2 class="text-lg font-bold mb-4">Find Users</h2>

<input
    type="text"
    id="search"
    placeholder="Search users..."
    class="w-full p-3 border rounded-xl mb-4"
/>

<div id="results">
    Start typing to search users
</div>

<script>
document.getElementById('search').addEventListener('input', function () {

    if (this.value.trim() === '') {
        document.getElementById('results').innerHTML =
            'Start typing to search users';
        return;
    }

    fetch(`/friends/search-users?search=${this.value}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('results').innerHTML = html;
        });

});

document.addEventListener('click', function (event) {

    const button = event.target.closest('.send-request');
    if (!button) return;

    const userId = button.dataset.user;

    fetch(`/friends/request/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            button.outerHTML =
                `<span class="text-gray-500 text-sm">Request Sent</span>`;
        }

    });

});
</script>