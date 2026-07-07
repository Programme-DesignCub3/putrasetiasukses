@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'required' => false,
    'colSpan' => null,
])

<label @class([
    'block text-sm font-bold',
    $colSpan => (bool) $colSpan,
])>
    {{ $label }}
    <input
        class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->except(['name', 'label', 'type', 'required', 'colSpan']) }}
    >
</label>
