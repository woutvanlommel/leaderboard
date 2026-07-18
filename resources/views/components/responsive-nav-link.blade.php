@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-3 py-2 rounded-lg text-sm font-medium text-primary bg-red-50 transition'
    : 'block w-full px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
