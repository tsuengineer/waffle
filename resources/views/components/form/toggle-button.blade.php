@props(['value', 'name'])

<label class="relative inline-flex items-center cursor-pointer mt-4">
    <input type="hidden" name="{{ $name }}" value="0">
    <input type="checkbox" value="{{ old($name, $value) }}" name="{{ $name }}" id="toggleCheckbox" class="sr-only peer" @if(old($name, $value) === '1') checked @endif>
    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-400"></div>
    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $slot }}</span>
</label>

<script>
    const toggleCheckbox = document.getElementById('toggleCheckbox');
    toggleCheckbox.addEventListener('change', () => {
        toggleCheckbox.value = toggleCheckbox.checked ? '1' : '0';
    });
</script>
