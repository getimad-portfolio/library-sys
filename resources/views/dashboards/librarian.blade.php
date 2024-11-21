<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-6 grid-rows-3 gap-2 mb-2">
        {{-- Totals --}}
        <x-dash-card header="Total Books Borrowed Today" class="col-span-2">
            <div class="grid h-72 place-items-center">
                <span class="text-9xl font-bold">{{ $totalBorrowed }}</span>
            </div>
        </x-dash-card>

        <x-dash-card header="Total Books Returned Today" class="col-span-2">
            <div class="grid h-72 place-items-center">
                <span class="text-9xl font-bold">{{ $totalReturned }}</span>
            </div>
        </x-dash-card>

        <x-dash-card header="Total Stock" class="col-span-2">
            <div class="grid h-72 place-items-center">
                <span class="text-9xl font-bold">{{ $totalStock }}</span>
            </div>
        </x-dash-card>

        {{-- Add new --}}
        <x-dash-card header="Add New Borrow" class="col-span-3">
            <div class="grid h-72 place-items-center">
                <a href="{{ route('borrows.create') }}" class="h-full w-full grid place-items-center rounded-md hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors duration-300 ease-in-out"">
                    <svg class="h-36 w-36 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </x-dash-card>

        <x-dash-card header="Add New Member" class="col-span-3">
            <div class="grid h-72 place-items-center">
                <a href="{{ route('members.create') }}" class="h-full w-full grid place-items-center rounded-md hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors duration-300 ease-in-out"">
                    <svg class="h-36 w-36 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </x-dash-card>

        <x-dash-card header="Add New Book" class="col-span-3">
            <div class="grid h-72 place-items-center">
                <a href="{{ route('books.create') }}" class="h-full w-full grid place-items-center rounded-md hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors duration-300 ease-in-out"">
                    <svg class="h-36 w-36 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </x-dash-card>

        <x-dash-card header="Add New Category" class="col-span-3">
            <div class="grid h-72 place-items-center">
                <a href="{{ route('categories.create') }}" class="h-full w-full grid place-items-center rounded-md hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors duration-300 ease-in-out"">
                    <svg class="h-36 w-36 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </x-dash-card>
    </div>
</x-app-layout>
