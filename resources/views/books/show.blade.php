<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        <a href="{{ route('books.index') }}" class="flex items-center gap-2 text-lg font-semibold text-gray-500 hover:underline">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
              
            Back
        </a>

        {{-- Profile Infos --}}
        <div class="flex flex-row bg-white rounded-md p-2 items-start gap-4 border">
            <img src="{{ Storage::url("covers/{$book->cover_image}"); }}" alt="Profile Image" class="h-64 w-30 object-cover rounded-md">
            <div class="flex flex-col gap-2 w-full">
                <h3 class="text-xl font-semibold">General Information</h3>
                <div class="flex flex-row items-start justify-between w-full">
                    <div class="flex flex-col gap-2">
                        <x-info-item title="Title" content="{{ $book->title }}" />
                        <x-info-item title="Author" content="{{ $book->author}}" />
                        <x-info-item title="ISBN" content="{{ $book->isbn }}" />
                        <x-info-item title="Stock" content="{{ $book->stock }}" />
                        <x-info-item title="Category" content="{{ $book->category->name }}" />
                        <x-info-item title="Stock" content="{{ $book->stock }}" />
                        <div class="flex items-center gap-2 justify-start pr-2">
                            <span class="text-gray-500">Actions:</span>
                            <a href="{{ route('books.edit', $book->id) }}" class="font-bold bg-green-500 p-2 rounded-full"></a>
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');" class="grid place-items-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold bg-red-500 p-2 rounded-full"></button>
                            </form>
                        </div>
                    </div>
                    <div class="w-96">
                        <x-info-item title="Description" content="{{ $book->description }}" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col mt-12 gap-5">
            <h3 class="text-3xl font-semibold">Reviews</h3>
            {{-- <div class="flex flex-col gap-2">
                @foreach ($reviews as $review)
                    <x-review-book-item :review="$review" />
                @endforeach
            </div> --}}
        </div>
    </div>
</x-app-layout>