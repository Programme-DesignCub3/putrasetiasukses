@props(['project'])

<article
    class="group flex h-full flex-col overflow-hidden border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a class="block overflow-hidden" href="{{ route('projects.show', $project) }}">
        <img class="aspect-4/3 w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $project->main_image_url }}" alt="{{ $project->name }}">
    </a>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-brand-red-dark text-sm font-black uppercase">{{ $project->category_names }}</p>
        <h2 class="mt-2 text-2xl font-black leading-tight text-black">{{ $project->name }}</h2>
        <p class="mt-2 text-sm font-semibold text-zinc-500">{{ $project->client }}</p>
        <p class="mt-4 line-clamp-4 text-sm font-medium leading-relaxed text-zinc-600">
            {{ $project->description }}
        </p>

        <a class="bg-brand-red hover:bg-brand-red-dark mt-6 inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-black uppercase text-white transition"
            href="{{ route('projects.show', $project) }}">
            {{ __('projects.view_detail') }}
        </a>
    </div>
</article>
