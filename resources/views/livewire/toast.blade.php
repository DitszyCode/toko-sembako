<div
    x-data="{ show: @entangle('show') }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    @hide-after-delay.window="setTimeout(() => { show = false }, 3000)"
    class="fixed bottom-4 right-4 z-[9999] max-w-sm"
>
    <div class="{{ $typeClasses }} rounded-lg shadow-lg p-4 flex items-center space-x-3">
        <span class="text-xl">{{ $icon }}</span>
        <p class="flex-1">{{ $message }}</p>
        <button
            @click="show = false"
            class="text-current opacity-70 hover:opacity-100 transition"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('hideAfterDelay', () => {
            setTimeout(() => {
                Livewire.dispatch('hide');
            }, 3000);
        });
    });
</script>
