@props([
    'name' => '',
    'label' => '',
    'required' => false,
    'rows' => 6,
    'colSpan' => null,
])

<label class="block text-sm font-bold {{ $colSpan ? "{$colSpan}" : '' }}">
    {{ $label }}
    <textarea
        class="mt-2 w-full bg-zinc-200 px-4 py-3 text-black"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->except(['name', 'label', 'required', 'rows', 'colSpan']) }}
    >{{ old($name) }}</textarea>
</label>
