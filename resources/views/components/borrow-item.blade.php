@php
    use App\Enums\BorrowStatus;
@endphp

<div class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white">
    <span class="w-1/12">
        <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
        </svg>
    </span>
    <span class="w-1/6 px-2">{{ $cnie }}</span>
    <span class="w-1/4 px-2">{{ $isbn }}</span>
    <span class="w-1/3 px-2">{{ $borrowed_at }}</span>
    <span class="w-1/5 px-2">{{ $due_date }}</span>
    <span class="w-1/5 px-2">{{ $returned_at }}</span>
    <div class="flex gap-2 items-center justify-center">
        <form action="{{ route('borrows.update', $borrowId) }}" method="POST" class="grid place-items-center">
            @csrf
            @method('PUT')
            <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs h-8 font-semibold uppercase" onchange="this.form.submit()">
                @foreach(BorrowStatus::cases() as $BorrowStatus)
                    <option value="{{ $BorrowStatus->value }}" {{ old('status', $status) == $BorrowStatus->value ? 'selected' : '' }} class="text-xs">
                        {{ $BorrowStatus->label() }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>