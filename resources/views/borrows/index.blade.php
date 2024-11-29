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
        <div id="review-pop-up" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white p-4 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-semibold mb-2">Add Review (Optional)</h2>
                <p class="mb-4">Kindly request the member to provide a rating for the book?</p>
                <div class="space-y-3">
                    <div class="space-y-2">
                        <x-input-label for="description" :value="__('Description')" class="text-xl" />
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
                    <button id="skip-review-btn" class="bg-gray-200 text-gray-800 px-4 py-2 rounded mr-2">Skip</button>
                    <button id="submit-review-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
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
            <div id="row-{{ $borrow->id }}" class="flex place-items-center p-2 rounded-md even:bg-gray-50 odd:bg-white shadow-2xl shadow-gray-100 border">
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
                
                <select name="status"
                    id="status-display-{{ $borrow->id }}"
                    data-borrow-id="{{ $borrow->id }}"
                    data-book-id="{{ $borrow->book->id }}"
                    data-member-id="{{ $borrow->member->id }}"
                    {{ $borrow->is_modified ? 'disabled' : '' }}
                    class="status-select border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs h-8 font-semibold uppercase"
                >
                    @foreach (BorrowStatus::cases() as $BorrowStatus)
                        <option     
                            value="{{ $BorrowStatus->value }}" 
                            {{ old('status', $borrow->status) == $BorrowStatus->value ? 'selected' : '' }} 
                            class="text-xs">
                            {{ $BorrowStatus->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endforeach
        </div>
    </div>

    @if (session('success'))        
        <x-notification-action />
    @endif

    <script>
        const reviewPopUp = document.getElementById('review-pop-up');

        let borrowId = null;
        let memberId = null;
        let bookId = null;
        let newStatus = null;

        document.querySelectorAll('.status-select').forEach((select) => {
            select.addEventListener('change', function () {
                borrowId = this.dataset.borrowId;
                memberId = this.dataset.memberId;
                bookId = this.dataset.bookId;

                newStatus = this.value;

                fetch('/borrows/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        borrow_id: borrowId,
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const statusSelect = document.getElementById(`status-display-${borrowId}`);
                        statusSelect.value = newStatus;
                        statusSelect.disabled = true;

                        const notification = document.createElement('div');
                        notification.id = 'notification';
                        notification.className = 'fixed top-5 right-5 bg-green-200 text-green-800 border border-green-300 px-2 py-2 rounded-md flex items-center gap-2 font-bold';
                        notification.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            ${data.message}
                        `;
                        document.body.appendChild(notification);

                        setTimeout(() => {
                            notification.remove();
                        }, 1500);

                        if (data.data.status == 'returned' || data.data.status == 'overdue') {
                            reviewPopUp.classList.remove('hidden');
                        }
                    }
                })
                .catch(error => {
                    console.log('Error:', error);
                });
            });
        });

        document.getElementById('submit-review-btn').addEventListener('click', function () {
            const description = document.getElementById('description');
            const rating = document.getElementById('rating');

            fetch('/borrows/add-review', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    member_id: memberId,
                    book_id: bookId,
                    rating: rating.value,
                    description: description.value
                })
            })
            .then(response => response.json())
            .catch(error => {
                console.log('Error:', error);
            });

            reviewPopUp.classList.add('hidden');
        });

        document.getElementById('skip-review-btn').addEventListener('click', function () {
            reviewPopUp.classList.add('hidden');
        });
    </script>
</x-app-layout>