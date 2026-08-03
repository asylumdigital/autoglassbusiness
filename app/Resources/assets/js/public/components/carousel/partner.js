import Swiper from "swiper";
import { Autoplay } from "swiper/modules";


export const PartnerCarousel = () => ({
    slider: null,
    init() {

        this.$refs.carousel.style.setProperty('--swiper-wrapper-transition-timing-function', 'linear');

        this.slider = new Swiper(this.$refs.carousel, {
            modules: [Autoplay],
            slidesPerView: 'auto',
            spaceBetween: 50,
            loop: true,
            speed: 5000,
            allowTouchMove: false,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                // pauseOnMouseEnter: true,
            }
        })
    }
});
