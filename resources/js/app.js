import "./bootstrap";
import Alpine from "alpinejs";

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

        if (!measurementId || document.querySelector("[data-google-analytics-script]")) {
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

window.Alpine = Alpine;
Alpine.start();

const needsSliders = () =>
    document.querySelector(
        [
            ".home-testimonials-swiper",
            ".home-partners-swiper",
            "[data-product-gallery]",
            "[data-featured-articles]",
        ].join(","),
    );

if (needsSliders()) {
    import("./sliders").then(({ initHomeSliders, initProductGalleries, initFeaturedArticlesSlider }) => {
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
    });
}
