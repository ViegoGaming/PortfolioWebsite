@props(['messages'])

@php
    $messages = collect($messages)
        ->flatten()
        ->filter(fn (mixed $message): bool => is_string($message))
        ->all();
@endphp

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'space-y-1 text-sm text-red-600']) }}>
        @foreach ($messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
