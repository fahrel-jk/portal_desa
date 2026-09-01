@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-ash-text']) }}>
    {{ $value ?? $slot }}
</label>
