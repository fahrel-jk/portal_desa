@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt/30 rounded-lg shadow-sm placeholder:text-ash-text']) }}>
