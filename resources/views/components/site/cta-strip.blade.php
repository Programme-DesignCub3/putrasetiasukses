@props([
    'text' => null,
])

<div class="bg-red cta-strip clamp-[py,32px,48px] bg-brand-red clamp-[mt,16,40] clamp-[px,6,12] sm:bg-size-[150%] relative flex min-h-32 justify-end bg-[url(assets/cta-bg.jpg)] bg-cover bg-center bg-no-repeat text-white bg-blend-multiply sm:min-h-36"
    x-data="scrollReveal">
    <img class="absolute bottom-0 left-0" src='{{ asset('assets/cta-person.png') }}' alt="person contact">
    <div class="flex w-full flex-col items-start justify-end max-sm:pb-80 max-sm:text-center sm:pl-60">
        <p class="clamp-[text,base,lg] font-semibold leading-tight">{!! $text ?? __('site.cta.strip-1') !!}</p>
        <p class="clamp-[text,base,lg] font-semibold leading-tight">{!! $text ?? __('site.cta.strip-2') !!}</p>
    </div>
</div>
