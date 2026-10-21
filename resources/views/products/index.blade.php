@php
    $breadcrumbs = [
        ['name' => __('Home'), 'url' => route('home')],
        ['name' => __('Produk'), 'url' => route('products.index')],
    ];
@endphp

@push('schemas')
    <x-seo.breadcrumbs :items="$breadcrumbs" />
@endpush

<x-layouts.app active-section="products">
    <main>

        <x-site.layout.container class="clamp-[py,48px,72px]">
            <div class="max-w-3xl">
                <x-site.section-heading :level="2" :title="__('products.title')" />
                <p class="mt-6 text-base font-semibold leading-relaxed text-zinc-600 sm:text-lg">
                    {{ __('products.intro') }}
                </p>
            </div>

            <livewire:product-list />
        </x-site.layout.container>

        <x-site.layout.container class="clamp-[pb,56px,72px]">
            @php
                $faqSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(
                        fn($faq) => [
                            '@type' => 'Question',
                            'name' => $faq['question'],
                            'acceptedAnswer' => [
                                '@type' => 'Answer',
                                'text' => $faq['answer'],
                            ],
                        ],
                        $faqs,
                    ),
                ];
            @endphp
            <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>

            <x-site.section-heading :title="__('products.faq_title')" />
            <div class="mt-10">
                <x-faq.accordion :faqs="$faqs" />
            </div>
        </x-site.layout.container>
    </main>
</x-layouts.app>
