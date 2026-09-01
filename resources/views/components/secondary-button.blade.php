<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-graphite-card border border-slate-border rounded-md font-semibold text-xs text-ivory-text uppercase tracking-widest shadow-sm hover:bg-obsidian-button/30 focus:outline-none focus:ring-2 focus:ring-cobalt focus:ring-offset-0 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
