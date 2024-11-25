<div class="flex gap-3 p-2 bg-white rounded-md border even:bg-gray-50 odd:bg-white hover:border-gray-300 transition-colors duration-200 ease-in-out shadow-2xl shadow-gray-100 relative">
    <a href="{{ route('books.show', $book->id) }}" class="flex w-full gap-3 h-60">
        <div class="relative h-60 w-72">
            <img class="h-full w-full object-cover rounded-sm" src="{{ Storage::url("covers/{$book->cover_image}"); }}" alt="Card image">
            <span class="px-1 font-bold bg-gray-100/70 text-gray-900 text-sm rounded-sm absolute top-1 left-1">Stock: {{ $book->stock }}</span>
            <span class="whitespace-nowrap px-1 rounded-sm bg-gray-100/70 text-gray-900 text-xs font-bold absolute bottom-1 right-1/2 translate-x-1/2">{{ $book->isbn }}</span>

        </div>

        <div class="w-full space-y-2">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 text-sm">By {{ $book->author }}</p>
            </div>
            <h2 class="text-2xl font-bold inline">{{ $book->title }}</h2></br>
            <span class="w-auto rounded-sm text-sm font-bold px-1" style="color: {{ $book->category_color }}; background-color: {{ $book->category_color . '26' }};">{{ $book->category_name }}</span>
            <p class="text-xs text-slate-500 h-32">
                {{ Str::limit($book->description, 260, '...') }}
            </p>
            <div class="flex items-center">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($book->avg_rating))
                        <!-- Full Star -->
                        <svg class="w-3 h-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                        </svg>
                    @elseif ($i == ceil($book->avg_rating))
                        <!-- Half Star -->
                        <svg class="w-3 h-3 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <defs>
                                <linearGradient id="halfStar">
                                    <stop offset="50%" stop-color="currentColor" />
                                    <stop offset="50%" stop-color="#d1d5db" />
                                </linearGradient>
                            </defs>
                            <path fill="url(#halfStar)" d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                        </svg>
                    @else
                        <!-- Empty Star -->
                        <svg class="w-3 h-3 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.614 1.575 8.08L12 18.896l-7.511 4.104 1.575-8.08L.587 9.306l8.332-1.151z"/>
                        </svg>
                    @endif
                @endfor
            </div>
        </div>
    </a>
    <div class="flex gap-2 items-center absolute right-2">
        <a href="{{ route('books.edit', $book->id) }}" class="bg-green-500 font-bold hover:bg-green-600 p-2 rounded-full transition-colors duration-300 ease-in-out"></a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');" class="grid place-items-center">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 font-bold hover:bg-red-600 p-2 rounded-full transition-colors duration-300 ease-in-out"></button>
        </form>
    </div>
</div>