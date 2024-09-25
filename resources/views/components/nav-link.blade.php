@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block bg-gray-900 border-l-4 border-gray-200 hover:bg-gray-700 py-2 px-3 rounded '
            : 'block bg-gray-700/50 hover:bg-gray-700 py-2 px-3 rounded ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
