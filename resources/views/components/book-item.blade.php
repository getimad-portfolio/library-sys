<div class="flex gap-3 bg-white p-2 rounded-md">
    <img class="w-32 h-48 object-cover rounded-sm" src="{{ $image }}" alt="Card image">

    <div class="flex-grow">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold inline">{{ $header }}</h2>
                <span class="text-slate-500 text-sm">&mdash; {{ $author }}</span>
            </div>
            <span class="text-xs">{{ $isbn }}</span>
        </div>
        <span class="bg-slate-200 rounded-sm px-1 text-slate-700 text-sm font-bold">{{ $category }}</span>
        <p class="mt-2">{{ $description }}</p>
    </div>

    <div class="flex flex-col gap-2 items-center justify-center">
        <a href="{{ route('books.edit', $bookId) }}" class="bg-green-100 font-bold hover:bg-green-200 text-green-700 py-2 px-4 rounded flex-grow w-24 grid place-items-center">
            Edite
        </a>
        <form action="{{ route('books.destroy', $bookId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-100 font-bold hover:bg-red-200 text-red-700 py-2 px-4 rounded w-24 grid place-items-center">
                Delete
            </button>
        </form>
    </div>
</div>