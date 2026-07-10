@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-[#becabc] rounded-xl text-sm text-[#171c1f] bg-white focus:outline-none focus:ring-2 focus:ring-[#005f2d] focus:border-[#005f2d] transition-all disabled:opacity-60 disabled:cursor-not-allowed']) }}>
