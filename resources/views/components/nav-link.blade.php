@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center text-sm font-bold leading-5 text-gray-900 focus:outline-none bg-gray-100 hover:bg-gray-200 rounded-md px-3 py-3 transition duration-150 ease-in-out text-xl'
            : 'inline-flex items-center text-sm font-bold leading-5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-md px-3 py-3 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out text-xl';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
