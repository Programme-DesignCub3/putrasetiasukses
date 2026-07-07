@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Kontak'), 'url' => route('contact')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-layouts.app active-section="contact">
    <main>
        <x-site.layout.page-hero :title="__('contact.title')" :image="asset('assets/contact-hero.png')" />

        <x-site.layout.container class="clamp-[py,32px,48px]">
            <x-site.section-heading :level="2" :label="__('contact.message_title')" />

            <livewire:contact-form />
        </x-site.layout.container>

        <x-site.layout.container class="pb-8">
            <x-site.section-heading :label="__('contact.locations')" />

            <div class="mt-8 grid gap-6">
                <x-contact.location-card label="Head Office" :address="__('site.head_office_address')" />
                <x-contact.location-card label="Warehouse" :address="__('site.warehouse_address')" />
            </div>
        </x-site.layout.container>

        <x-site.layout.container class="pb-16">
            <x-site.cta-strip />
        </x-site.layout.container>
    </main>
</x-layouts.app>
