@props(['active'])

@php
    $classes = $active ?? false ? 'inline-flex items-center px-1 pt-1 border-b-2 border-yellow-300 dark:border-indigo-600 text-md font-medium leading-5 text-yellow-400 hover:text-yellow-500 dark:text-gray-100 focus:outline-none focus:border-yellow-700 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-md font-medium leading-5 text-yellow-400 dark:text-gray-400 hover:text-yellow-500 dark:hover:text-gray-300 hover:border-yellow-300 dark:hover:border-gray-700 focus:outline-none focus:text-yellow-500 dark:focus:text-gray-300 focus:border-yellow-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a wire:navigate {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
