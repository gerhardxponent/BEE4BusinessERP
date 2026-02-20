{{-- Emit 'notify-success' to show toast --}}
@props([
    'duration' => '2800'
])

<div 
    wire:key="session-message"
    x-data="{ show: false, message: '' }" 
    x-on:notify-success.window="() => {
        message = $event.detail.message;
        show = true; 
        setTimeout(() => { 
            show = false;
            setTimeout(() => {
                message = '';
            }, 200);
        }, {{ $duration }});
    }"
    x-show="show"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    class="group bg-white border-l-4 border-emerald-500 py-6 px-8 text-lg font-bold rounded-lg shadow-2xl fixed z-50 top-20 right-5 space-y-4"
    >
    <div class="flex flex-row items-center space-x-3">
        <x-icons.check />
        <span x-text="message"></span>
    </div>

    <div 
        x-on:click="show = false"
        class="hidden group-hover:block bg-white absolute -top-6 -left-3 bg-white-500 shadow-lg rounded-full p-1 cursor-pointer"
        >
        <x-icons.close size="18" />
    </div>
</div>