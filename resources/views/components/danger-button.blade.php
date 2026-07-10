<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-5 py-2.5 bg-[#ba1a1a] border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-[#93000a] focus:outline-none focus:ring-2 focus:ring-[#ba1a1a] focus:ring-offset-2 active:scale-95 transition-all duration-150']) }}>
    {{ $slot }}
</button>
