@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Tentang Kami'), 'url' => route('about')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-layouts.app>
    <main>
        {{-- <x-site.layout.page-hero :title="__('about.title')" :image="asset('assets/about/about-header.png')" /> --}}
    </main>
</x-layouts.app>
