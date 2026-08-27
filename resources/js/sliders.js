import Swiper from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import {
    Autoplay,
    EffectFade,
    FreeMode,
    Navigation,
    Pagination,
    Thumbs,
} from "swiper/modules";

export function initHeroSlider() {
    if (document.querySelector(".home-hero")) {
        new Swiper(".home-hero", {
            modules: [Navigation, Pagination, Autoplay, EffectFade],
            loop: true,

            speed: 800,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".home-hero-button-next",
                prevEl: ".home-hero-button-prev",
            },
        });
    }
}

export function initHomeSliders() {
    if (document.querySelector(".home-testimonials-swiper")) {
        new Swiper(".home-testimonials-swiper", {
            modules: [Pagination, Autoplay],
            loop: true,
            spaceBetween: 10,
            autoHeight: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".home-testimonials-pagination",
                clickable: true,
            },
        });
    }

    if (document.querySelector(".home-partners-swiper")) {
        new Swiper(".home-partners-swiper", {
            modules: [Autoplay],
            loop: true,
            slidesPerView: 2,
            spaceBetween: 10,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            spaceBetween: 0,
            breakpoints: {
                640: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });
    }
}

export function initAboutSlider() {
    const container = document.querySelector(".about-gallery-nav");

    if (!container) return;

    const swiperEl = container.querySelector(".gallery-slider");

    if (!swiperEl) return;

    new Swiper(swiperEl, {
        modules: [Navigation, Autoplay],
        loop: true,
        speed: 300,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: container.querySelector(".slider-nav-next"),
            prevEl: container.querySelector(".slider-nav-prev"),
        },
    });
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
                slidesPerView: 3.2,
                spaceBetween: 12,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    640: {
                        slidesPerView: 4.4,
                        spaceBetween: 14,
                    },
                },
            });
        }

        const mainSwiper = new Swiper(mainElement, {
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

        if (thumbs) {
            mainSwiper.on("slideChange", () => {
                thumbs.slideTo(mainSwiper.realIndex, 300);
            });
        }
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

export function initCategorySlider() {
    const container = document.querySelector("[data-category-slider]");

    if (!container) return;

    const swiperEl = container.querySelector(".category-slider-swiper");

    if (!swiperEl) return;

    if (swiperEl.swiper) {
        swiperEl.swiper.destroy(true, true);
    }

    new Swiper(swiperEl, {
        modules: [Navigation, FreeMode],
        slidesPerView: "auto",
        spaceBetween: 8,
        freeMode: true,
        navigation: {
            nextEl: container.querySelector(".slider-nav-next"),
            prevEl: container.querySelector(".slider-nav-prev"),
        },
    });
}

export function initHomeProjectSlider() {
    const container = document.querySelector("[data-home-projects]");

    if (!container) return;

    const swiperEl = container.querySelector(".home-projects-swiper");

    if (!swiperEl) return;

    new Swiper(swiperEl, {
        modules: [Navigation, Autoplay],
        slidesPerView: 1,
        spaceBetween: 16,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: container.querySelector(".slider-nav-next"),
            prevEl: container.querySelector(".slider-nav-prev"),
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1280: {
                slidesPerView: 5,
            },
        },
    });
}
