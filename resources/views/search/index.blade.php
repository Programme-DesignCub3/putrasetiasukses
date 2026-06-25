<x-layouts.app body-class="bg-white font-sans text-brand-ink antialiased" active-section="search">
    <main>
        <x-site.layout.page-hero :title="__('search.title')" image="https://placehold.co/1400x320/4b5563/ffffff?text=Cari" />

        <x-site.layout.container class="clamp-[py,48px,72px]">
            <livewire:search-results />
        </x-site.layout.container>
    </main>
</x-layouts.app>
