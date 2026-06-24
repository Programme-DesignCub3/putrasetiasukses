import "./bootstrap";

import Swiper from "swiper";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { Autoplay, FreeMode, Navigation, Pagination, Thumbs } from "swiper/modules";

const initHomeSliders = () => {
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
            // autoplay: true,
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
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initHomeSliders);
} else {
    initHomeSliders();
}

const initProductGalleries = () => {
    document.querySelectorAll("[data-product-gallery]").forEach((gallery) => {
        const mainElement = gallery.querySelector(".product-gallery-main");
        const thumbElement = gallery.querySelector(".product-gallery-thumbs");

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
                nextEl: gallery.querySelector(".product-gallery-next"),
                prevEl: gallery.querySelector(".product-gallery-prev"),
            },
            pagination: {
                el: gallery.querySelector(".product-gallery-pagination"),
                clickable: true,
            },
            thumbs: {
                swiper: thumbs,
            },
        });
    });
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initProductGalleries);
} else {
    initProductGalleries();
}

const cookieConsentKey = "pssb_cookie_consent_v1";

const getCookieConsent = () => {
    try {
        return window.localStorage.getItem(cookieConsentKey);
    } catch {
        return null;
    }
};

const setCookieConsent = (value) => {
    try {
        window.localStorage.setItem(cookieConsentKey, value);
    } catch {
        return;
    }
};

const gtag = (...args) => {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(args);
};

const loadGoogleAnalytics = () => {
    const measurementId = window.siteAnalytics?.googleMeasurementId;

    if (
        !measurementId ||
        document.querySelector("[data-google-analytics-script]")
    ) {
        return;
    }

    const script = document.createElement("script");
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(measurementId)}`;
    script.dataset.googleAnalyticsScript = "true";
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    gtag("js", new Date());
    gtag("config", measurementId);
};

const applyCookieConsent = (consent) => {
    gtag("consent", "default", {
        analytics_storage: "denied",
        ad_storage: "denied",
        ad_user_data: "denied",
        ad_personalization: "denied",
    });

    if (consent !== "accepted") {
        return;
    }

    gtag("consent", "update", {
        analytics_storage: "granted",
    });

    loadGoogleAnalytics();
};

const initCookieConsent = () => {
    if (!window.siteAnalytics?.cookieConsentEnabled) {
        applyCookieConsent("accepted");
        return;
    }

    const banner = document.querySelector("[data-cookie-consent]");
    const currentConsent = getCookieConsent();

    applyCookieConsent(currentConsent);

    if (!banner) {
        return;
    }

    if (currentConsent) {
        banner.hidden = true;
        return;
    }

    banner
        .querySelector("[data-cookie-accept]")
        ?.addEventListener("click", () => {
            setCookieConsent("accepted");
            applyCookieConsent("accepted");
            banner.hidden = true;
        });

    banner
        .querySelector("[data-cookie-reject]")
        ?.addEventListener("click", () => {
            setCookieConsent("rejected");
            applyCookieConsent("rejected");
            banner.hidden = true;
        });
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCookieConsent);
} else {
    initCookieConsent();
}
