@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 bg-[#f0fdf4] border border-[#0e7a3d]/20 rounded-xl flex items-center gap-2 text-sm font-medium text-[#005f2d]']) }}>
        <span class="material-symbols-outlined filled-icon text-[18px] shrink-0">check_circle</span>
        {{ $status }}
    </div>
@endif
