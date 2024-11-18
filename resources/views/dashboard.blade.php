<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 gap-2">
        {{-- Charts --}}
        <div class="col-span-2">
            <x-dash-card header="Books Added In The Past 30 Days" class="p-2 bg-white rounded-md">
                <canvas id="bookschart"></canvas>
            </x-dash-card>
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
    <script>
        var ctx = document.getElementById('bookschart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($booksChart['labels']),
                datasets: [{
                    label: 'Data',
                    data: @json($booksChart['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Increment scale by 1
                        },
                    }
                }
            }
        });
    </script>
</x-app-layout>
