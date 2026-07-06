@php
    $projectImages = collect([
        [
            'url' => $project->main_image_url,
            'alt' => $project->name,
        ],
    ])
        ->merge($project->gallery_images ?? [])
        ->filter(fn(array $image): bool => filled($image['url'] ?? null))
        ->unique('url')
        ->values();

    $projectGallery = $projectImages->map(fn($img) => [
        'url' => $img['url'],
        'alt' => $img['alt'] ?? $project->name,
    ]);

    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Proyek'), 'url' => route('projects.index')],
        ['name' => $project->name, 'url' => route('projects.show', $project)],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-app body-class="bg-white font-sans text-brand-ink antialiased" active-section="projects"
    x-data="galleryLightbox({ images: {{ Illuminate\Support\Js::from($projectGallery) }} })">
    <main class="clamp-[py,48px,80px] mx-auto max-w-7xl px-4 sm:px-5 lg:px-8">
        <a href="{{ route('projects.index') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-bold uppercase text-brand-red hover:text-brand-red-dark transition">
            <x-lucide-arrow-left class="size-4" stroke-width="3" />
            {{ __('site.back') }}
        </a>

        <div class="grid gap-10 lg:grid-cols-2">
        <x-site.gallery-slider :images="$projectImages" :name="$project->name"
            firstImageTransitionName="project-image-{{ $project->id }}" />
        <x-site.gallery-lightbox />

        <section class="flex flex-col">
            <p class="text-brand-red-dark text-2xl font-black">{{ $project->category_names }}</p>
            <h1 class="mt-3 text-5xl font-black leading-none text-black sm:text-6xl">{{ $project->name }}</h1>

            <div class="mt-6 space-y-3 text-lg font-semibold text-zinc-600">
                @if ($project->client)
                    <p><span class="font-black text-black">Klien:</span> {{ $project->client }}</p>
                @endif
                @if ($project->location)
                    <p><span class="font-black text-black">Lokasi:</span> {{ $project->location }}</p>
                @endif
                @if ($project->completion_date)
                    <p><span class="font-black text-black">Selesai:</span>
                        {{ $project->completion_date->isoFormat('MMMM Y') }}</p>
                @endif
            </div>

            <div class="mt-8">
                <h2 class="section-title">{{ __('projects.description') }}</h2>
                <div class="max-h-115 mt-6 overflow-y-auto pr-4 text-lg font-medium leading-relaxed text-zinc-700">
                    @foreach (preg_split('/\R+/', $project->description) as $paragraph)
                        <p class="mb-6 last:mb-0">{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>

            <a class="bg-brand-red hover:bg-brand-red-dark mt-10 inline-flex w-full max-w-xl items-center justify-center gap-4 rounded-full px-8 py-5 text-2xl font-black uppercase text-white transition"
                href="{{ route('contact') }}">
                <x-lucide-phone class="h-8 w-8" />
                {{ __('projects.inquiry') }}
            </a>
        </section>
        </div>

        @if (filled($project->content))
            <div class="mx-auto mt-16 max-w-5xl">
                <div
                    class="prose prose-lg prose-zinc max-w-none [&_a]:text-brand-red [&_a]:font-black [&_blockquote]:border-brand-red [&_blockquote]:border-l-4 [&_blockquote]:pl-5 [&_blockquote]:italic [&_h2]:mt-10 [&_h2]:text-3xl [&_h2]:font-black [&_h2]:text-black [&_h3]:mt-8 [&_h3]:text-2xl [&_h3]:font-black [&_h3]:text-black [&_li]:mb-2 [&_ol]:my-7 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-7 [&_ul]:my-7 [&_ul]:list-disc [&_ul]:pl-6">
                    {!! $project->renderRichContent('content') !!}
                </div>
            </div>
        @endif
    </main>
</x-app>
