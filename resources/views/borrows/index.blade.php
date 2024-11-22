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
        <div id="confirmationModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white p-4 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-semibold mb-2">Add Review</h2>
                <p class="mb-4">Kindly request the member to provide a rating for the book?</p>
                <div class="space-y-3">
                    <div class="space-y-2">
                        <x-input-label for="description" :value="__('Description (Optional)')" class="text-xl" />
                        <x-text-area id="description" name="description" type="text" class="mt-1 block w-full h-44" :value="old('description')" autofocus autocomplete="description" />
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="rating" :value="__('Rating')" class="text-xl" />
                        <select name="rating" id="rating" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-32" required>
                            @for ($i = 0; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button id="skipBtn" class="bg-gray-200 text-gray-800 px-4 py-2 rounded mr-2">Skip</button>
                    <button id="confirmBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </div>
        </div>

        <div>
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
                    <svg class="w-7 h-7 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </span>
                <span class="w-1/6 px-2 font-semibold">{{ $borrow->member->cnie }}</span>
                <span class="w-1/6 px-2 font-semibold">{{ $borrow->book->isbn }}</span>
                <span class="w-1/6 px-2">{{ $borrow->borrowed_at ? $borrow->borrowed_at->format('Y-m-d') : 'N/A' }}</span>
                <span class="w-1/6 px-2">{{ $borrow->due_date ? $borrow->due_date->format('Y-m-d') : 'N/A' }}</span>
                <span class="w-1/6 px-2">{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : 'N/A' }}</span>
                
                <!-- Form -->
                <form action="{{ route('borrows.update', $borrow->id) }}" method="POST" class="borrow-form grid place-items-center">
                    @csrf
                    @method('PUT')
                    <select name="status" id="status" class="status-select border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs h-8 font-semibold uppercase"
                        {{ $borrow->book->stock == 0 && $borrow->status != 'borrowed' ? 'disabled' : '' }}>
                        @foreach (BorrowStatus::cases() as $BorrowStatus)
                            <option 
                                value="{{ $BorrowStatus->value }}" 
                                {{ old('status', $borrow->status) == $BorrowStatus->value ? 'selected' : '' }} 
                                class="text-xs">
                                {{ $BorrowStatus->label() }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endforeach
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('confirmationModal');
            const skipBtn = document.getElementById('skipBtn');
            const confirmBtn = document.getElementById('confirmBtn');
            let currentForm = null;
            let currentStatus = null;

            // Event listener for all select elements
            document.body.addEventListener('change', (event) => {
                if (event.target.matches('.status-select')) {
                    const value = event.target.value;
                    currentStatus = value;
                    currentForm = event.target.closest('.borrow-form'); // Store the current form

                    console.log("Selected status:", currentStatus);

                    if (event.isTrusted) {
                        if (value === 'returned') {
                            modal.classList.remove('hidden'); // Show the modal
                        } else {
                            currentForm.submit();
                        }
                    }
                }
            });

            // Close modal on cancel
            skipBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                if (currentForm) {
                    currentForm.submit();
                    currentForm = null; // Reset the form reference
                }
            });

            // Submit the form on confirm
            confirmBtn.addEventListener('click', () => {
                if (currentForm) {
                    const reviewInput = document.getElementById('description');
                    const ratingInput = document.getElementById('rating');

                    const clonedReview = document.createElement('input');
                    clonedReview.type = 'hidden';
                    clonedReview.name = reviewInput.name;
                    clonedReview.value = reviewInput.value;

                    const clonedRating = document.createElement('input');
                    clonedRating.type = 'hidden';
                    clonedRating.name = ratingInput.name;
                    clonedRating.value = ratingInput.value;

                    const clonedisConfirmed = document.createElement('input');
                    clonedisConfirmed.type = 'hidden';
                    clonedisConfirmed.name = 'isConfirmed';
                    clonedisConfirmed.value = true;

                    currentForm.appendChild(clonedReview);
                    currentForm.appendChild(clonedRating);
                    currentForm.appendChild(clonedisConfirmed);

                    currentForm.submit();
                }
            });
        });
    </script>
</x-app-layout>