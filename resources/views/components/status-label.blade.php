@props(['status'])

@php
    $classes = 'inline-block rounded-full border px-2 py-1 mt-2 text-xs font-medium ' . $status->color();
@endphp

<span {{ $attributes(['class' => $classes]) }}>
    {{ $slot }}
</span>
