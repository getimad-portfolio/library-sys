<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Add New Category') }}
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

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 pb-12">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-xl" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus autocomplete="name" />
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" class="text-xl" />
            <x-text-area id="description" name="description" type="text" class="mt-1 block w-full h-44" :value="old('description')" required autofocus autocomplete="description" />
        </div>

        <!-- Color -->
        <div>
            <x-input-label for="favcolor" :value="__('Color')" class="text-xl" />
            <x-text-input id="favcolor" name="favcolor" type="color" class="mt-1" :value="old('#000', 'favcolor')" required autofocus autocomplete="favcolor" />
        </div>

        <x-form-button type="submit">
            Add Category
        </x-form-button>
    </form>
</x-app-layout>