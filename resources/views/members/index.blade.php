<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Members Management') }}
        </h2>
    </x-slot>

    <div>
        <div>
            <form action="{{ route('members.index') }}" method="GET" class="flex gap-2 mb-4">
                <select name="sort" id="sort" class="outline-none rounded-md border-none w-44" onchange="this.form.submit()">
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : ' ' }}>Ascending</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : ' ' }}>Descending</option>
                </select>
                <input type="search" name="search" placeholder="Search" value="{{ request('search') }}" onkeypress="submitOnEnter(event)" class="outline-none rounded-md border-none flex-grow"/>
                <a href={{ route('members.create') }} class="px-2 py-2 bg-gray-200 rounded-md flex gap-2 hover:bg-gray-300 transition-colors duration-300 ease-in-out cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    
                    Add Member
                </a>
            </form>
        </div>

        <div class="flex flex-col gap-2">
            @foreach ($members as $member)
                <x-member-item fullName="{{ $member->full_name }}" email="{{ $member->email }}" cnie="{{ $member->cnie }}" phoneNumber="{{ $member->phone_number }}" memberId="{{ $member->id }}" />
            @endforeach
        </div>
    </div>
</x-app-layout>