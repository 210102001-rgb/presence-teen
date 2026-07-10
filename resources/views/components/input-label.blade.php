@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-[#171c1f] mb-1']) }}>
    {{ $value ?? $slot }}
</label>
