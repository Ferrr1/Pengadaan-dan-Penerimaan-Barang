@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block bg-gray-400 dark:bg-gray-900 border-l-4 border-black dark:border-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 py-2 px-3 rounded '
            : 'block bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 py-2 px-3 rounded hover:bg-gray-300 ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
