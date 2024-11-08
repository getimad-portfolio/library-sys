@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 ease-in-out']) !!}>
    {{ $slot }}
</button>