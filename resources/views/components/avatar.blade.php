@props(['name' => 'Unknown'])

@php
    $sep_name = explode(' ', $name);

    $short_name = '';

    foreach ($sep_name as $n) {
        $short_name = $short_name . $n[0];
    }
@endphp

<div class="avatar placeholder">
    <div {{ $attributes->merge(['class' => 'bg-white text-black rounded-full']) }}>
        <span>{{ $short_name }}</span>
    </div>
</div>