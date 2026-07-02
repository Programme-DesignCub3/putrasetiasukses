import { animate, animateView, inView, stagger, spring } from "motion";
import "./bootstrap";

const COOKIE_CONSENT_KEY = "pssb_cookie_consent_v1";

document.addEventListener("alpine:init", () => {
    Alpine.data("cookieConsent", () => ({
        visible: false,
        init() {
            const current = this.getConsent();

            if (current) {
                this.applyConsent(current);
                return;
            }

            this.applyConsent(null);
            this.visible = true;
        },
        getConsent() {
            try {
                return window.localStorage.getItem(COOKIE_CONSENT_KEY);
            } catch {
                return null;
            }
        },
        setConsent(value) {
            try {
                window.localStorage.setItem(COOKIE_CONSENT_KEY, value);
            } catch {
                //
            }
        },
        gtag(...args) {
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push(args);
        },
        loadGoogleAnalytics() {
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
            this.gtag("js", new Date());
            this.gtag("config", measurementId);
        },
        applyConsent(consent) {
            this.gtag("consent", "default", {
                analytics_storage: "denied",
                ad_storage: "denied",
                ad_user_data: "denied",
                ad_personalization: "denied",
            });

            if (consent === "accepted") {
                this.gtag("consent", "update", {
                    analytics_storage: "granted",
                });
                this.loadGoogleAnalytics();
            }
        },
        accept() {
            this.setConsent("accepted");
            this.applyConsent("accepted");
            this.visible = false;
        },
        reject() {
            this.setConsent("rejected");
            this.applyConsent("rejected");
            this.visible = false;
        },
    }));

    Alpine.data("scrollReveal", (keyframes = {}) => ({
        init() {
            const fromY = keyframes.y?.[0] ?? 24;
            const rect = this.$el.getBoundingClientRect();
            const isInViewport = rect.top < window.innerHeight && rect.bottom > 0;

            if (isInViewport) {
                return;
            }

            this.$el.style.opacity = "0";
            this.$el.style.transform = `translateY(${fromY}px)`;
            this.$el.style.willChange = "opacity, transform";

            inView(
                this.$el,
                () => {
                    animate(
                        this.$el,
                        { opacity: [0, 1], y: [fromY, 0], ...keyframes },
                        { duration: 0.5, easing: "ease-out" },
                    );
                },
                { amount: 0.2 },
            );
        },
    }));

    Alpine.data("staggerFade", (options = {}) => ({
        init() {
            inView(
                this.$el,
                () => {
                    const children = [...this.$el.children];

                    if (children.every((child) => parseFloat(getComputedStyle(child).opacity) > 0.9)) {
                        return;
                    }

                    animate(
                        children,
                        { opacity: [0, 1], y: [50, 0] },
                        {
                            delay: stagger(0.10, { ease: "easeIn" }),
                            ...options,
                        },
                    );
                },
                { amount: 0.15 },
            );
        },
    }));

    Alpine.data("galleryLightbox", (options = {}) => ({
        isOpen: false,
        images: options.images ?? [],
        currentIndex: 0,
        activeThumb: null,
        scale: 1,
        panX: 0,
        panY: 0,

        get currentImage() {
            return this.images[this.currentIndex];
        },

        get transformStyle() {
            if (this.scale === 1) return "";
            return `scale(${this.scale}) translate(${this.panX}px, ${this.panY}px)`;
        },

        get zoomPercent() {
            return Math.round(this.scale * 100);
        },

        open(thumbEl, index) {
            this.activeThumb = thumbEl;
            this.currentIndex = index;

            animateView(() => {
                this.isOpen = true;
            }, { type: spring, duration: 0.5, bounce: 0.15 }).add(thumbEl, ".lightbox-image");
        },

        close() {
            const thumb = this.activeThumb;
            this.scale = 1;
            this.panX = 0;
            this.panY = 0;

            animateView(() => {
                this.isOpen = false;
            }, { type: spring, duration: 0.5, bounce: 0.15 }).add(".lightbox-image", thumb);
        },

        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.scale = 1;
            this.panX = 0;
            this.panY = 0;
        },

        prev() {
            this.currentIndex =
                (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.scale = 1;
            this.panX = 0;
            this.panY = 0;
        },

        toggleZoom(event) {
            if (this.scale > 1) {
                this.scale = 1;
                this.panX = 0;
                this.panY = 0;
            } else {
                this.zoomIn(event);
            }
        },

        zoomIn(event) {
            this.scale = 2.5;

            if (event) {
                const rect = event.currentTarget.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width - 0.5;
                const y = (event.clientY - rect.top) / rect.height - 0.5;
                this.panX = -x * 100;
                this.panY = -y * 100;
            } else {
                this.panX = 0;
                this.panY = 0;
            }
        },

        handleWheel(event) {
            event.preventDefault();

            const delta = event.deltaY > 0 ? -0.25 : 0.25;
            const newScale = Math.min(Math.max(this.scale + delta, 1), 5);

            if (newScale !== this.scale) {
                const rect = event.currentTarget.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width - 0.5;
                const y = (event.clientY - rect.top) / rect.height - 0.5;

                const ratio = newScale / this.scale;
                this.panX = x * 100 * (1 - ratio) + this.panX * ratio;
                this.panY = y * 100 * (1 - ratio) + this.panY * ratio;
                this.scale = newScale;
            }
        },
    }));

    Alpine.data("aboutGallery", (options = {}) => ({
        isOpen: false,
        images: options.images ?? [],
        currentIndex: 0,
        activeThumb: null,
        thumbs: [],

        init() {
            this.thumbs = [...this.$el.querySelectorAll("button > img")];
        },

        get currentImage() {
            return this.images[this.currentIndex];
        },

        open(thumbEl, index) {
            this.currentIndex = index;
            this.activeThumb = thumbEl;

            const overlay = document.querySelector(".about-lb-overlay");
            const img = overlay.querySelector(".about-lb-image");
            img.src = this.currentImage.url;
            img.alt = this.currentImage.alt;

            animateView(() => {
                overlay.classList.add("is-open");
                this.isOpen = true;
            }, { type: spring, duration: 0.5, bounce: 0.15 }).add(thumbEl, ".about-lb-image");
        },

        close() {
            const thumb = this.thumbs[this.currentIndex] ?? this.activeThumb;
            const overlay = document.querySelector(".about-lb-overlay");

            animateView(() => {
                overlay.classList.remove("is-open");
                this.isOpen = false;
            }, { type: spring, duration: 0.5, bounce: 0.15 }).add(".about-lb-image", thumb);
        },

        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.activeThumb = this.thumbs[this.currentIndex] ?? this.activeThumb;

            const overlay = document.querySelector(".about-lb-overlay");
            const img = overlay.querySelector(".about-lb-image");
            img.src = this.currentImage.url;
            img.alt = this.currentImage.alt;
        },

        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.activeThumb = this.thumbs[this.currentIndex] ?? this.activeThumb;

            const overlay = document.querySelector(".about-lb-overlay");
            const img = overlay.querySelector(".about-lb-image");
            img.src = this.currentImage.url;
            img.alt = this.currentImage.alt;
        },

        goTo(index) {
            this.currentIndex = index;
            this.activeThumb = this.thumbs[index] ?? this.activeThumb;

            const overlay = document.querySelector(".about-lb-overlay");
            const img = overlay.querySelector(".about-lb-image");
            img.src = this.currentImage.url;
            img.alt = this.currentImage.alt;
            img.src = this.currentImage.url;
            img.alt = this.currentImage.alt;
        },
    }));

    Alpine.data("staggerList", (options = {}) => ({
        observer: null,
        ready: false,

        init() {
            inView(this.$el, () => { this.ready = true; }, { amount: 0.15 });

            this.observer = new MutationObserver(() => {
                if (!this.ready) return;

                const children = [...this.$el.children];
                if (children.length === 0) return;

                animate(
                    children,
                    { opacity: [0, 1], y: [50, 0] },
                    {
                        delay: stagger(0.10, { ease: "easeIn" }),
                        ...options,
                    },
                );
            });
            this.observer.observe(this.$el, { childList: true });
        },

        destroy() {
            this.observer?.disconnect();
        },
    }));
});

const hasSliders = () =>
    document.querySelector(
        [
            ".home-hero",
            ".home-testimonials-swiper",
            ".home-partners-swiper",
            "[data-gallery]",
            "[data-featured-articles]",
        ].join(","),
    );

if (hasSliders()) {
    import("./sliders").then(
        ({
            initHeroSlider,
            initHomeSliders,
            initProductGalleries,
            initFeaturedArticlesSlider,
        }) => {
            const run = () => {
                initHeroSlider();
                initHomeSliders();
                initProductGalleries();
                initFeaturedArticlesSlider();
            };

            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", run);
            } else {
                run();
            }
        },
    );
}
