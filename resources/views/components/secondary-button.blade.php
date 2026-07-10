<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white border border-[#becabc] rounded-xl font-semibold text-sm text-[#5c5f61] hover:bg-[#f0f4f8] focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:ring-offset-2 transition-all duration-150']) }}>
    {{ $slot }}
</button>
