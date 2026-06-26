import Alpine from "alpinejs";
import { animate, inView, scroll, stagger, hover, press } from "motion";
import "./bootstrap";

const COOKIE_CONSENT_KEY = "pssb_cookie_consent_v1";

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

window.Motion = { animate, inView, scroll, stagger, hover, press };

Alpine.magic("motion", () => window.Motion);

Alpine.magic("animate", () => (el, keyframes, options) =>
    animate(el, keyframes, options),
);

Alpine.data("scrollReveal", (options = {}) => ({
    init() {
        inView(
            this.$el,
            () => {
                animate(
                    this.$el,
                    { opacity: [0, 1], y: [24, 0] },
                    { duration: 0.5, easing: "ease-out", ...options },
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
                animate(
                    this.$el.children,
                    { opacity: [0, 1], y: [16, 0] },
                    {
                        duration: 0.4,
                        easing: "ease-out",
                        delay: stagger(0.06),
                        ...options,
                    },
                );
            },
            { amount: 0.15 },
        );
    },
}));

Alpine.data("staggerList", (options = {}) => ({
    observer: null,
    animated: false,

    init() {
        const animateChildren = (force = false) => {
            if (!force && this.animated) return;

            const children = [...this.$el.children];

            if (children.length === 0) return;

            animate(
                children,
                { opacity: [0, 1], y: [16, 0] },
                {
                    duration: 0.4,
                    easing: "ease-out",
                    delay: stagger(0.06),
                    ...options,
                },
            );

            this.animated = true;
        };

        inView(this.$el, () => animateChildren(), { amount: 0.15 });

        this.observer = new MutationObserver(() => animateChildren(true));
        this.observer.observe(this.$el, { childList: true });
    },

    destroy() {
        this.observer?.disconnect();
    },
}));

window.Alpine = Alpine;
Alpine.start();

const needsSliders = () =>
    document.querySelector(
        [
            ".home-testimonials-swiper",
            ".home-partners-swiper",
            "[data-gallery]",
            "[data-featured-articles]",
        ].join(","),
    );

if (needsSliders()) {
    import("./sliders").then(
        ({
            initHomeSliders,
            initProductGalleries,
            initFeaturedArticlesSlider,
        }) => {
            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", () => {
                    initHomeSliders();
                    initProductGalleries();
                    initFeaturedArticlesSlider();
                });
            } else {
                initHomeSliders();
                initProductGalleries();
                initFeaturedArticlesSlider();
            }
        },
    );
}
