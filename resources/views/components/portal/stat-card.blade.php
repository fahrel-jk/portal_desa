@props(['label', 'value'])

<div {{ $attributes->merge(['class' => 'bg-graphite-card rounded-xl shadow-sm border border-slate-border/10 p-6']) }}>
    <dt class="text-sm font-medium text-ash-text truncate">{{ $label }}</dt>
    <dd class="mt-2 text-3xl font-bold text-ivory-text">{{ $value }}</dd>
</div>
