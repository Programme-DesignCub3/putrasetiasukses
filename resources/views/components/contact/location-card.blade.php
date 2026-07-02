@props([
    'label' => '',
    'address' => '',
])

<div class="flex gap-5">
    <span class="bg-brand-red flex h-16 w-16 flex-none items-center justify-center rounded-full">
        <x-lucide-map-pin class="h-9 w-9" fill="white" />
    </span>
    <p><strong>{{ $label }}</strong><br>{{ $address }}</p>
</div>
