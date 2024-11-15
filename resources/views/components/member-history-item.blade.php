<div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white">
    <span class="w-1/12">
        <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
        </svg>
    </span>
    <span class="w-1/6 px-2 font-semibold">{{ $borrow->book->isbn }}</span>
    <span class="w-1/6 px-2">{{ $borrow->book->title }}</span>
    <span class="w-1/6 px-2">{{ $borrow->borrowed_at ? $borrow->borrowed_at->format('Y-m-d') : 'N/A' }}</span>
    <span class="w-1/6 px-2">{{ $borrow->due_date ? $borrow->due_date->format('Y-m-d') : 'N/A' }}</span>
    <span class="w-1/6 px-2">{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : 'N/A' }}</span>
    <span class="px-2 capitalize text-left">{{ $borrow->status ? $borrow->status : 'N/A' }}</span>
</div>