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
                <x-borrow-item borrowed_at="{{ $borrow->borrowed_at }}" due_date="{{ $borrow->due_date }}" returned_at="{{ $borrow->returned_at }}" status="{{ $borrow->status }}" isbn="{{ $borrow->book->isbn }}" cnie="{{ $borrow->member->cnie }}" borrowId="{{ $borrow->id }}" />
            @endforeach
        </div>
    </div>
</x-app-layout>