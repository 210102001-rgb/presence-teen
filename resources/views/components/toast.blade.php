@props([
    'position' => 'top-right',
])

<div
    x-data="toastStore"
    x-on:toast.window="addToast($event.detail)"
    class="fixed z-[100] flex flex-col gap-3 pointer-events-none
           {{ $position === 'top-right' ? 'top-20 right-4 sm:right-6' : '' }}
           {{ $position === 'top-left' ? 'top-20 left-4 sm:left-6' : '' }}
           {{ $position === 'bottom-right' ? 'bottom-6 right-4 sm:right-6' : '' }}
           {{ $position === 'bottom-left' ? 'bottom-6 left-4 sm:left-6' : '' }}"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-2 sm:translate-x-4"
            x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
            x-transition:leave-end="opacity-0 -translate-y-2 sm:translate-x-4"
            class="pointer-events-auto w-80 max-w-[calc(100vw-2rem)] bg-white rounded-xl border shadow-lg p-4 flex items-start gap-3"
            :class="{
                'border-[#0e7a3d]/20': toast.type === 'success',
                'border-[#ba1a1a]/20': toast.type === 'error',
                'border-[#ea580c]/20': toast.type === 'warning',
                'border-[#2563eb]/20': toast.type === 'info'
            }"
        >
            {{-- Icon --}}
            <span class="material-symbols-outlined filled-icon text-[20px] shrink-0 mt-0.5"
                  :class="{
                      'text-[#005f2d]': toast.type === 'success',
                      'text-[#ba1a1a]': toast.type === 'error',
                      'text-[#ea580c]': toast.type === 'warning',
                      'text-[#2563eb]': toast.type === 'info'
                  }"
                  x-text="{
                      success: 'check_circle',
                      error: 'error',
                      warning: 'warning',
                      info: 'info'
                  }[toast.type]">
            </span>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-[#171c1f]" x-text="toast.title" x-show="toast.title"></p>
                <p class="text-xs text-[#5c5f61] mt-0.5 leading-relaxed" x-text="toast.message"></p>
            </div>

            {{-- Close --}}
            <button @click="removeToast(toast.id)" class="shrink-0 p-1 rounded-lg text-[#5c5f61] hover:text-[#171c1f] hover:bg-[#f0f4f8] transition-colors">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>

            {{-- Progress bar --}}
            <div class="absolute bottom-0 left-0 h-[3px] rounded-b-xl transition-all ease-linear"
                 :class="{
                     'bg-[#005f2d]': toast.type === 'success',
                     'bg-[#ba1a1a]': toast.type === 'error',
                     'bg-[#ea580c]': toast.type === 'warning',
                     'bg-[#2563eb]': toast.type === 'info'
                 }"
                 :style="'width: ' + toast.progress + '%'"
                 x-show="toast.progress > 0">
            </div>
        </div>
    </template>
</div>
