@php
    use App\Enums\BorrowStatus;
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Borrows Management') }}
        </h2>
    </x-slot>

    <div>
        <div class="">
            <form action="{{ route('borrows.index') }}" method="GET" class="flex gap-2 mb-4">
                <select name="status" id="status" class="outline-none rounded-md border-none w-44" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    @foreach(BorrowStatus::cases() as $BorrowStatus)
                        <option value="{{ $BorrowStatus->value }}" {{ request('status') == $BorrowStatus->value ? 'selected' : '' }}>
                            {{ $BorrowStatus->label() }}
                        </option>
                    @endforeach
                </select>
                <input type="search" name="search" placeholder="Search" value="{{ request('search') }}" onkeypress="submitOnEnter(event)" class="outline-none rounded-md border-none flex-grow"/>
                <a href={{ route('borrows.create') }} class="px-2 py-2 bg-gray-200 rounded-md flex gap-2 hover:bg-gray-300 transition-colors duration-300 ease-in-out cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    
                    Add Borrow
                </a>
            </form>
        </div>

        <div class="flex flex-col gap-3">
            @foreach ($borrows as $borrow)

            <div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white shadow-2xl shadow-gray-100 border">
                <span class="w-1/12">
                    <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </span>
                <span class="w-1/6 px-2 font-semibold">{{ $borrow->member->cnie }}</span>
                <span class="w-1/6 px-2 font-semibold">{{ $borrow->book->isbn }}</span>
                <span class="w-1/6 px-2">{{ $borrow->borrowed_at ? $borrow->borrowed_at->format('Y-m-d') : 'N/A' }}</span>
                <span class="w-1/6 px-2">{{ $borrow->due_date ? $borrow->due_date->format('Y-m-d') : 'N/A' }}</span>
                <span class="w-1/6 px-2">{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : 'N/A' }}</span>
                <div class="flex gap-2 items-center justify-center">
                    <form action="{{ route('borrows.update', $borrow->id) }}" method="POST" class="grid place-items-center">
                        @csrf
                        @method('PUT')
                        <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs h-8 font-semibold uppercase" onchange="this.form.submit()" {{ $borrow->book->stock == 0 && $borrow->status != 'borrowed' ? 'disabled' : '' }}>
                            @foreach(BorrowStatus::cases() as $BorrowStatus)
                                <option value="{{ $BorrowStatus->value }}" {{ old('status', $borrow->status) == $BorrowStatus->value ? 'selected' : '' }} class="text-xs">
                                    {{ $BorrowStatus->label() }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>