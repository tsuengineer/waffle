<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-900 border border-gray-800 rounded-md font-semibold text-xs text-gray-100 uppercase tracking-widest hover:bg-gray-800 focus:bg-gray-800 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
