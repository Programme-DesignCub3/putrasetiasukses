<template x-teleport="body">
    <div x-show="isOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center"
        x-on:keydown.escape.window="close()"
        x-on:keydown.arrow-right.window="next()"
        x-on:keydown.arrow-left.window="prev()">
        <div class="absolute inset-0 bg-black/80" @click="close()"></div>

        <button
            class="absolute right-4 top-4 z-10 flex size-10 items-center justify-center rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-white"
            type="button" @click="close()" aria-label="Close">
            <x-lucide-x class="size-5" stroke-width="3" />
        </button>

        <div
            class="relative z-[1] flex max-h-[90vh] max-w-[95vw] items-center justify-center overflow-hidden"
            x-on:wheel.prevent="handleWheel"
            x-on:dblclick="toggleZoom"
            style="cursor: zoom-in"
            x-bind:style="scale > 1 ? 'cursor: grab' : 'cursor: zoom-in'">
            <img class="max-h-[90vh] max-w-[95vw] rounded object-contain drop-shadow-2xl transition-transform duration-200 ease-out"
                x-bind:src="currentImage.url"
                x-bind:alt="currentImage.alt"
                x-bind:style="transformStyle ? `transform: ${transformStyle}` : ''"
                @click="toggleZoom">
        </div>

        <template x-if="scale > 1">
            <div class="absolute left-4 top-4 z-10 flex items-center gap-2 rounded-full bg-black/60 px-3 py-1.5 text-sm text-white">
                <span x-text="zoomPercent + '%'"></span>
                <button class="ml-1 flex size-6 items-center justify-center rounded-full bg-white/20 hover:bg-white/40"
                    type="button" @click="scale = 1; panX = 0; panY = 0" aria-label="Reset zoom">
                    <x-lucide-x class="size-3.5" stroke-width="3" />
                </button>
            </div>
        </template>

        <template x-if="images.length > 1">
            <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                <template x-for="(image, i) in images" :key="i">
                    <button
                        class="size-2.5 rounded-full transition"
                        x-bind:class="i === currentIndex ? 'bg-white' : 'bg-white/40'"
                        type="button"
                        @click="currentIndex = i; scale = 1; panX = 0; panY = 0">
                    </button>
                </template>
            </div>
        </template>

        <template x-if="images.length > 1">
            <>
                <button
                    class="absolute left-4 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-white"
                    type="button" @click="prev()" aria-label="Previous">
                    <x-lucide-chevron-left class="size-6" stroke-width="2.5" />
                </button>
                <button
                    class="absolute right-4 top-1/2 z-10 flex size-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-white"
                    type="button" @click="next()" aria-label="Next">
                    <x-lucide-chevron-right class="size-6" stroke-width="2.5" />
                </button>
            </>
        </template>
    </div>
</template>
