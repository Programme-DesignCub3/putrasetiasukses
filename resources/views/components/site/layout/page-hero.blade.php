@props([
    'title',
    'image',
])

<section class="mx-auto max-w-7xl px-0 sm:px-5 lg:px-8">
    <div class="inner-hero min-h-48 bg-cover bg-center sm:min-h-56 lg:min-h-64" style="background-image: linear-gradient(rgb(185 0 0 / 0.68), rgb(185 0 0 / 0.68)), url('{{ $image }}')">
        <div class="flex min-h-48 items-center justify-center px-5 text-center sm:min-h-56 lg:min-h-64">
            <h1 class="text-4xl font-black text-white sm:text-5xl lg:text-6xl">{{ $title }}</h1>
        </div>
    </div>
</section>
