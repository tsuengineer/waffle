<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-3 py-2 bg-red-700 border rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
