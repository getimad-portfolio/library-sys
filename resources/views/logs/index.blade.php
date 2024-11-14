@php
    use App\Enums\UserRole;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-gray-800">
            {{ __('Logs & Activities') }}
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

    <div>
        <form action="{{ route('logs.index') }}" method="GET" class="flex gap-2 mb-4">
            <input type="search" name="search" placeholder="Search" value="{{ request('search') }}" onkeypress="submitOnEnter(event)" class="outline-none rounded-md border-none flex-grow"/>
            <select name="sort" id="sort" class="outline-none rounded-md border-none w-44" onchange="this.form.submit()">
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : ' ' }}>Ascending</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : ' ' }}>Descending</option>
            </select>
            <select name="type" id="type" class="outline-none rounded-md border-none w-44" onchange="this.form.submit()">
                <option value="">All Users</option>
                @foreach (UserRole::cases() as $userRole)
                    <option value="{{ $userRole->value }}" {{ request('type') == $userRole->value ? 'selected' : ' ' }}>{{ $userRole->label() }}</option>
                @endforeach
            </select>
            <select name="date" id="date" class="outline-none rounded-md border-none w-44" onchange="this.form.submit()">
                <option value="all">All Time</option>
                <option value="24h" {{ request('date') == '24h' ? 'selected' : ' ' }}>24 Hourses</option>
                <option value="3d" {{ request('date') == '3d' ? 'selected' : ' ' }}>3 Days</option>
                <option value="7d" {{ request('date') == '7d' ? 'selected' : ' ' }}>7 Days</option>
                <option value="1m" {{ request('date') == '1m' ? 'selected' : ' ' }}>1 Month</option>
            </select>
        </form>

        <div class="flex flex-col gap-2">
            @foreach ($audits as $audit)
                <x-audit-item :audit="$audit" />
            @endforeach
        </div>
    </div>
</x-app-layout>