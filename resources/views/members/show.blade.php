<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Member Profile') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        <a href="{{ route('members.index') }}" class="flex items-center gap-2 text-lg font-semibold text-gray-500 hover:underline">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
              
            Back
        </a>

        {{-- Profile Infos --}}
        <div class="flex flex-row bg-white rounded-md p-2 items-center gap-4">
            <img src="{{ asset('images/profile-image.jpg') }}" alt="Profile Image" class="h-[170px] w-[170px] object-cover rounded-md">
            <div class="flex flex-col gap-2 w-full">
                <h3 class="text-xl font-semibold">General Information</h3>
                <div class="flex flex-row items-start justify-between w-full">
                    <div class="flex flex-col gap-2">
                        <x-member-info-item title="Full Name" content="{{ $member->full_name }}" />
                        <x-member-info-item title="CNIE" content="{{ $member->cnie }}" />
                        <x-member-info-item title="Created By" content="{{ $member->user->full_name }}" />
                        <x-member-info-item title="Created At" content="{{ $member->created_at }}" />
                    </div>
                    <div class="w-96">
                        <x-member-info-item title="Adress" content="{{ $member->adress }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row bg-white rounded-md p-2 items-center justify-between">
            <h3 class="text-xl font-semibold">Contacts</h3>
            <x-member-info-item title="Email" content="{{ $member->email }}" />
            <x-member-info-item title="Phone Number" content="{{ $member->phone_number }}" />
            <div class="flex flex-col gap-2"></div>
        </div>
        
        <div class="flex flex-col mt-12 gap-5">
            <h3 class="text-3xl font-semibold">Borrows History</h3>
            <div class="">
                @foreach ($borrows as $borrow)
                    <x-member-history-item :borrow="$borrow" />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>