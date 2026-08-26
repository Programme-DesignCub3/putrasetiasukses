@props(['title', 'content'])

<article class="shadow-top text-brand-red clamp-[px,6,12] clamp-[py,3,6] rounded-lg text-start">
    <h2 class="text-3xl font-black uppercase">{{ $title }}</h2>
    <p class="clamp-[text,xs,base] mt-4">
        {{ $content }}</p>
</article>
