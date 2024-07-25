<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-zinc-900 border border-zinc-800 rounded-md font-semibold text-xs text-zinc-100 uppercase tracking-widest hover:bg-zinc-800 focus:bg-zinc-800 active:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
