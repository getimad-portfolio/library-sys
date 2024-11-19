<div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white shadow-2xl shadow-gray-100 border">
    <span class="w-1/12">
        <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>        
    </span>
    <span class="w-1/4">{{ $audit->user_type }}</span>
    <span class="w-1/4 font-semibold">{{ $audit->user_name }}</span>
    <span class="w-1/4"><b>{{ $audit->auditable_type }}</b> has {{ $audit->event }}.</span>
    <span class="w-1/4 text-right">{{ $audit->created_at }}</span>
</div>
