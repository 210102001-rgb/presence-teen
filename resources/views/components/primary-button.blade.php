<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-[#005f2d] border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-[#0e7a3d] focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:ring-offset-2 active:scale-95 transition-all duration-150']) }}>
    {{ $slot }}
</button>
