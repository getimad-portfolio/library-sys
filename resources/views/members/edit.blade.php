<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Edit Member') }}
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

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 pb-12">
        @csrf
        @method('PUT')

        <!-- Full Name -->
        <div>
            <x-input-label for="full_name" :value="__('Full Name')" class="text-xl" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $member->full_name)" required autofocus autocomplete="full_name" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xl" />
            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', $member->email)" required autofocus autocomplete="email" />
        </div>

        <!-- Adress -->
        <div>
            <x-input-label for="adress" :value="__('Adress')" class="text-xl" />
            <x-text-area id="adress" name="adress" type="text" class="mt-1 block w-full h-44" :value="old('adress', $member->adress)" required autofocus autocomplete="adress">
                {{ old('adress', $member->adress) }}
            </x-text-area>
        </div>

        <!-- CNIE -->
        <div>
            <x-input-label for="cnie" :value="__('CNIE')" class="text-xl" />
            <x-text-input id="cnie" name="cnie" type="text" class="mt-1 block w-full" :value="old('cnie', $member->cnie)" required autofocus autocomplete="cnie" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" class="text-xl" />
            <x-text-input id="phone_number" name="phone_number" type="number" class="mt-1 block w-full" :value="old('phone_number', $member->phone_number)" required autofocus autocomplete="phone_number" />
        </div>

        <!-- Created By -->
        <div>
            <x-input-label for="created_by" :value="__('Created By')" class="text-xl" />
            <x-text-input id="created_by" name="created_by" type="text" class="mt-1 block w-full disabled:bg-gray-200 disabled:text-gray-800" :value="old('created_by', $createdBy)" disabled  />
        </div>

        <x-form-button type="submit">
            Edit Member
        </x-form-button>
    </form>
</x-app-layout>