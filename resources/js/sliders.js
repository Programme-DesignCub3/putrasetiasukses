import Swiper from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import {
    Autoplay,
    FreeMode,
    Navigation,
    Pagination,
    Thumbs,
} from "swiper/modules";

export function initHomeSliders() {
    if (document.querySelector(".home-testimonials-swiper")) {
        new Swiper(".home-testimonials-swiper", {
            modules: [Pagination],
            loop: true,
            spaceBetween: 10,
            autoHeight: true,
            pagination: {
                el: ".home-testimonials-pagination",
                clickable: true,
            },
        });
    }

    if (document.querySelector(".home-partners-swiper")) {
        new Swiper(".home-partners-swiper", {
            modules: [Pagination, Autoplay],
            loop: true,
            slidesPerView: 1,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            spaceBetween: 0,
            pagination: {
                el: ".home-partners-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
            },
        });
    }
}

export function initProductGalleries() {
    document.querySelectorAll("[data-gallery]").forEach((gallery) => {
        const mainElement = gallery.querySelector(".gallery-main");
        const thumbElement = gallery.querySelector(".gallery-thumbs");

        if (!mainElement) {
            return;
        }

        const slideCount = mainElement.querySelectorAll(".swiper-slide").length;
        let thumbs = null;

        if (thumbElement) {
            thumbs = new Swiper(thumbElement, {
                modules: [FreeMode],
                slidesPerView: 3,
                spaceBetween: 12,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 14,
                    },
                },
            });
        }

        new Swiper(mainElement, {
            modules: [Navigation, Pagination, Thumbs],
            loop: slideCount > 1,
            spaceBetween: 12,
            navigation: {
                nextEl: gallery.querySelector(".slider-nav-next"),
                prevEl: gallery.querySelector(".slider-nav-prev"),
            },
            pagination: {
                el: gallery.querySelector(".gallery-pagination"),
                clickable: true,
            },
            thumbs: {
                swiper: thumbs,
            },
        });
    });
}

export function initFeaturedArticlesSlider() {
    const container = document.querySelector("[data-featured-articles]");

    if (!container) return;

    const swiperEl = container.querySelector(".featured-articles-swiper");

    if (!swiperEl) return;

    new Swiper(swiperEl, {
        modules: [Navigation],
        slidesPerView: 1,
        spaceBetween: 24,
        navigation: {
            nextEl: container.querySelector(".slider-nav-next"),
            prevEl: container.querySelector(".slider-nav-prev"),
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
        },
    });
}
