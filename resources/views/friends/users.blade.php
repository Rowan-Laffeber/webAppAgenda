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

    if (!event.target.classList.contains('send-request')) {        
        return;
    }
    

    const userId = event.target.dataset.user;

    fetch(`/friends/request/${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(() => {
        event.target.innerText = 'Request Sent';
        event.target.disabled = true;
    });

});
</script>