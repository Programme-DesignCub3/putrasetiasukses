import './bootstrap';

import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const initHomeSliders = () => {
    if (document.querySelector('.home-testimonials-swiper')) {
        new Swiper('.home-testimonials-swiper', {
            modules: [Pagination],
            loop: true,
            autoHeight: true,
            pagination: {
                el: '.home-testimonials-pagination',
                clickable: true,
            },
        });
    }

    if (document.querySelector('.home-partners-swiper')) {
        new Swiper('.home-partners-swiper', {
            modules: [Navigation, Pagination],
            loop: true,
            slidesPerView: 1,
            spaceBetween: 0,
            navigation: {
                nextEl: '.home-partners-next',
                prevEl: '.home-partners-prev',
            },
            pagination: {
                el: '.home-partners-pagination',
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

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHomeSliders);
} else {
    initHomeSliders();
}
