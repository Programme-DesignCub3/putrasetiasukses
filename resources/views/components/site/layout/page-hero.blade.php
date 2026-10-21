@props(['title', 'headline', 'subheadline', 'image'])

<x-site.layout.container class="px-0">
    <div class="group relative min-h-48 overflow-hidden sm:min-h-56 lg:min-h-64">
        <div class="bg-brand-red absolute inset-0 bg-cover bg-center bg-blend-multiply transition-transform duration-700 ease-out group-hover:scale-105"
            style="background-image: url('{{ $image }}')"></div>
        <div
            class="relative flex min-h-48 flex-col items-center justify-center px-5 py-2 text-center text-white sm:min-h-56 lg:min-h-64">
            @if (!empty($headline))
                <h1 class="clamp-[text,xl,4xl] font-black">{{ $headline }} </h1>
            @endif
            @if (!empty($subheadline))
                <p class="">{{ $subheadline }}</p>
            @endif
        </div>
    </div>
</x-site.layout.container>
