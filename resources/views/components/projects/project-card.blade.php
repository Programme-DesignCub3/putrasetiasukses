@props(['project'])

<article
    class="group flex h-full flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <a class="block overflow-hidden" href="{{ route('projects.show', $project) }}">
        <img class="aspect-4/3 w-full object-cover transition duration-300 group-hover:scale-105"
            src="{{ $project->main_image_url }}" alt="{{ $project->name }}"
            style="view-transition-name: project-image-{{ $project->id }}">
    </a>

    <div class="flex flex-1 flex-col gap-2 p-3 sm:p-5">
        <p class="text-brand-red-dark text-label font-black uppercase">
            {{ $project->category_names }}
        </p>

        <div class="flex flex-col gap-1">
            <h2 class="clamp-[text,xs,sm] font-black leading-tight text-black">
                {{ $project->name }}
            </h2>
            <p class="text-label font-semibold text-zinc-500">
                {{ $project->client }}
            </p>
        </div>

        <p class="text-label line-clamp-3 flex-1 font-medium leading-relaxed text-zinc-600">
            {{ $project->description }}
        </p>

        <a class="bg-brand-red hover:bg-brand-red-dark text-label clamp-[mt,1,3] clamp-[px,4,6] clamp-[py,2,3] inline-flex items-center justify-center rounded-full font-black uppercase text-white transition"
            href="{{ route('projects.show', $project) }}">
            {{ __('projects.view_detail') }}
        </a>
    </div>
</article>
