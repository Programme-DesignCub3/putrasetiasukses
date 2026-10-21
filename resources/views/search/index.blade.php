<x-layouts.app active-section="search">
    <main>
        {{-- <x-site.layout.page-hero :title="__('search.title')" :image="asset('assets/about/about-header.png')" /> --}}

        <x-site.layout.container class="clamp-[py,48px,72px]">
            <livewire:search-results />
        </x-site.layout.container>
    </main>
</x-layouts.app>
