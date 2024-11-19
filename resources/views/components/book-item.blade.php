<div class="flex gap-3 bg-white p-2 rounded-md shadow-2xl shadow-gray-100 border">
    <div class="relative h-60 w-52">
        <img class="h-full w-full object-cover rounded-sm" src="{{ Storage::url("covers/{$book->cover_image}"); }}" alt="Card image">
        <span class="px-1 font-bold bg-gray-100/70 text-gray-900 text-sm rounded-sm absolute top-1 left-1">Stock: {{ $book->stock }}</span>
    </div>

    <div class="w-full">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold inline">{{ $book->title }}</h2>
            <span class="text-slate-500 text-sm">&mdash; {{ $book->author }}</span>
        </div>
        <span class="rounded-sm text-blue-700 text-sm font-bold">{{ $book->category_name }}</span>
        <p class="my-4 min-h-28">{{ Str::limit($book->description, 550, '...') }}</p>
        <span class="bg-gray-200 rounded-sm p-1 text-gray-700 text-xs font-bold">{{ $book->isbn }}</span>
    </div>

    <div class="flex flex-col gap-2 items-center justify-center">
        <a href="{{ route('books.edit', $book->id) }}" class="bg-green-100 font-bold hover:bg-green-200 text-green-700 py-2 px-4 rounded flex-grow w-24 grid place-items-center">
            Edite
        </a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-100 font-bold hover:bg-red-200 text-red-700 py-2 px-4 rounded w-24 grid place-items-center">
                Delete
            </button>
        </form>
    </div>
</div>