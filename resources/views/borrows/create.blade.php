@php
    $currentDate = date('Y-m-d');
    $tomorrowDate = date('Y-m-d', strtotime('+1 day'));
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Add new Borrow') }}
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

    <form action="{{ route('borrows.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <div class="grid grid-cols-2 h-[500px] gap-8">
            <div class="flex flex-col gap-2">
                <div class="bg-white rounded-md p-2 h-full shadow-2xl shadow-gray-100 border">
                    <h2 class="text-2xl font-bold mb-3">Members</h2>
                    <table class="table-auto w-full">
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="w-12"></th>
                            <th>CNIE</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                        @foreach ($members as $member)
                        <tr class="hover:bg-gray-100 cursor-pointer" onclick="
                            document.getElementById('member{{ $member->id }}').click();
                        ">
                            <td><input type="radio" name="member_id" id="member{{ $member->id }}" value="{{ $member->id }}" class=""></td>
                            <td class="font-semibold">{{ $member->cnie }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->email }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="bg-white rounded-md p-2 h-full shadow-2xl shadow-gray-100 border">
                    <h2 class="text-2xl font-bold mb-3">Books</h2>
                    <table class="table-auto w-full">
                        <tr class="text-left text-gray-500 text-sm">
                            <th class="w-12"></th>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                        </tr>
                        @foreach ($books as $book)
                            <tr class="hover:bg-gray-100 cursor-pointer" onclick="
                                document.getElementById('book{{ $book->id }}').click();
                            ">
                                <td><input type="radio" name="book_id" id="book{{ $book->id }}" value="{{ $book->id }}"></td>
                                <td class="font-semibold">{{ $book->isbn }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

            <div class="mt-16 flex flex-col gap-6">
                <h2 class="text-2xl font-bold">Schedule</h2>
                <div class="flex items-center gap-2">
                    <x-input-label for="from" class="text-sm font-bold">FROM</x-input-label>
                    <x-text-input id="from" name="borrowed_at" type="date" class="flex-grow read-only:bg-gray-200 read-only:text-gray-700" value="{{ $currentDate }}" readonly required/>
                    <x-input-label for="to" class="text-sm font-bold">TO</x-input-label>
                    <x-text-input id="to" name="due_date" type="date" class="flex-grow" value="{{ $tomorrowDate }}" required/>
                </div>
                <x-form-button type="submit" class="w-full">
                    Add Borrow
                </x-form-button>
            </div>
        </form>
            
</x-app-layout>