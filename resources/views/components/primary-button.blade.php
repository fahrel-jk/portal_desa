<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-cobalt border border-transparent rounded-full font-medium text-sm text-pure-white tracking-wide hover:bg-cobalt-hover hover:scale-[1.02] focus:bg-cobalt-hover active:bg-cobalt focus:outline-none focus:ring-2 focus:ring-cobalt/50 focus:ring-offset-0 transition-all ease-in-out duration-200 shadow-lg shadow-cobalt/20']) }}>
    {{ $slot }}
</button>
