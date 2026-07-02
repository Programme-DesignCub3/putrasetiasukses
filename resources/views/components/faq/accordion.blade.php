@props([
    'faqs' => [],
])

<div class="" x-data="{ active: null }">
    <div class="flex flex-col gap-y-4 divide-zinc-200">
        @foreach ($faqs as $index => $faq)
            <div class="rounded-lg bg-gray-200 px-6 py-4">
                <button
                    class="flex w-full items-center justify-between gap-4 text-left font-bold leading-snug text-zinc-800"
                    type="button" @click="active = (active === {{ $index }} ? null : {{ $index }})"
                    :aria-expanded="active === {{ $index }}">
                    <span>{{ $faq['question'] }}</span>
                    <x-lucide-chevron-down class="size-5 shrink-0 text-zinc-400 transition-transform duration-200"
                        x-bind:class="{ 'rotate-180': active === {{ $index }} }" stroke-width="2" />
                </button>
                <div class="mt-3 overflow-hidden text-sm leading-relaxed text-zinc-600"
                    x-show="active === {{ $index }}" x-transition:enter="transition-all duration-200 ease-out"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
