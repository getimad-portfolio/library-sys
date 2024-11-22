<div class="flex items-center gap-2 p-2 justify-between rounded-md even:bg-gray-50 odd:bg-white">
    <span class="pr-2">
        <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
        </svg>     
    </span>
    <div class="flex flex-col flex-grow">
        <div class="flex place-items-center">
            <span class="flex-grow font-semibold">{{ $review->member->full_name }}</span>
            <span class="flex-grow px-2">{{ $review->member->cnie }}</span>
            <span class="w-3/12 px-2 font-bold">
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($review->rating))
                            <!-- Full Star -->
                            <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                            </svg>
                        @elseif ($i == ceil($review->rating))
                            <!-- Half Star -->
                            <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="halfStar">
                                        <stop offset="50%" stop-color="currentColor" />
                                        <stop offset="50%" stop-color="gray" />
                                    </linearGradient>
                                </defs>
                                <path fill="url(#halfStar)" d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                            </svg>
                        @else
                            <!-- Empty Star -->
                            <svg class="w-6 h-6 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                            </svg>
                        @endif
                    @endfor
                </div>
                
            </span>
            <span class="w-1/6 px-2 text-right">{{ $review->created_at }}</span>
        </div>
        <div class="text-xs flex">
            <span class="font-bold text-slate-500">Description:</span>
            <p class="flex-grow px-1 text-slate-900">{{ $review->description}}</p>
        </div>
    </div>
</div>