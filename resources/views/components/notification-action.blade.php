<div id="notification" class="fixed top-5 right-5 bg-green-200 text-green-800 border border-green-300 px-2 py-2 rounded-md flex items-center gap-2 font-bold">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>

    {{ session('success') }}
</div>

<script>
    setTimeout(() => {
        document.getElementById('notification').remove();
    }, 1500);
</script>