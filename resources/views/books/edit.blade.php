<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 pb-12">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('Title')" class="text-xl" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $book->title)" required autofocus autocomplete="title" />
        </div>

        {{-- Author --}}
        <div>
            <x-input-label for="author" :value="__('Author')" class="text-xl" />
            <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author', $book->author)" required autofocus autocomplete="author" />
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" class="text-xl" />
            <x-text-area id="description" name="description" type="text" class="mt-1 block w-full h-44" required autofocus autocomplete="description">
                {{ old('description', $book->description) }}
            </x-text-area>
        </div>

        <!-- ISBN -->
        <div>
            <x-input-label for="isbn" :value="__('ISBN')" class="text-xl" />
            <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn', $book->isbn)" required autofocus autocomplete="title" />
        </div>

        <!-- Number of Pages -->
        <div>
            <x-input-label for="number_of_pages" :value="__('Number Of Pages')" class="text-xl" />
            <x-text-input id="number_of_pages" name="number_of_pages" type="number" class="mt-1 block w-full" :value="old('number_of_pages', $book->number_of_pages)" required autofocus autocomplete="number_of_pages" />
        </div>

        <!-- Cover Image -->
        <div>
            <x-input-label for="cover_image" :value="__('Cover Image')" class="text-xl" />
            <x-text-input id="cover_image" name="cover_image" type="file" class="mt-1 block w-full" :value="old('cover_image', $book->cover_image)" required autofocus autocomplete="cover_image" />
        </div>

        <!-- Publication Date -->
        <div>
            <x-input-label for="publication_date" :value="__('Publication Date')" class="text-xl" />
            <x-text-input id="publication_date" name="publication_date" type="date" class="mt-1 block w-full" :value="old('publication_date', $book->publication_date)" required autofocus autocomplete="publication_date" />
        </div>

        <!-- Category -->
        <div>
            <x-input-label for="category_id" :value="__('Category')" class="text-xl" />
            <select name="category_id" id="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-form-button type="submit">
            Edit Book
        </x-form-button>
    </form>

</x-app-layout>