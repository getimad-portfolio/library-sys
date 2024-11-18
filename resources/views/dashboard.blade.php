<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 gap-2">
        {{-- Charts --}}
        <div class="col-span-2 bg-white rounded-md">

        </div>

        {{-- Top records --}}
        <div class="flex flex-col gap-2">
            {{-- BOOKS --}}
            <x-dash-card header="Top Books">
                <ul>
                    <li class="flex justify-between text-xs font-bold text-gray-500">
                        <span>ISBN</span>
                        <span>COUNT</span>
                    </li>

                    @foreach ($topBooks as $topBook)
                        <li class="flex justify-between">
                            <span>{{ $topBook->isbn }}</span>
                            <span>{{ $topBook->borrow_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-dash-card>

            {{-- CATEGORIES --}}
            <x-dash-card header="Top Categories">
                <ul>
                    <li class="flex justify-between text-xs font-bold text-gray-500">
                        <span>Name</span>
                        <span>COUNT</span>
                    </li>

                    @foreach ($topCategories as $topCategorie)
                        <li class="flex justify-between">
                            <span>{{ $topCategorie->name }}</span>
                            <span>{{ $topCategorie->borrow_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-dash-card>

            {{-- MEMBERS --}}
            <x-dash-card header="Top Members">
                <ul>
                    <li class="flex justify-between text-xs font-bold text-gray-500">
                        <span>CNIE</span>
                        <span>COUNT</span>
                    </li>

                    @foreach ($topMembers as $topMember)
                        <li class="flex justify-between">
                            <span>{{ $topMember->cnie }}</span>
                            <span>{{ $topMember->borrow_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-dash-card>
        </div>
    </div>
</x-app-layout>
