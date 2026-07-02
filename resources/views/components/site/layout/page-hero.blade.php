@props(['title', 'image'])

<section class="mx-auto max-w-7xl px-0 sm:px-5 lg:px-8">
    <div class="group relative min-h-48 overflow-hidden sm:min-h-56 lg:min-h-64">
        <div class="bg-brand-red absolute inset-0 bg-cover bg-center bg-blend-multiply transition-transform duration-700 ease-out group-hover:scale-105"
            style="background-image: url('{{ $image }}')"></div>
        <div class="relative flex min-h-48 items-center justify-center px-5 text-center sm:min-h-56 lg:min-h-64">
            <h1 class="text-4xl font-black text-white sm:text-5xl lg:text-6xl">{{ $title }}</h1>
        </div>
    </div>
</section>
