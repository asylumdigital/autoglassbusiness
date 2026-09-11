import Swiper from "swiper";
import { Pagination, Navigation } from "swiper/modules";

export const Carousel = () => ({
    slider: null,
    init() {
        this.slider = new Swiper(this.$refs.carousel, {
            modules: [Pagination, Navigation],
            slidesPerView: 1,
            loop: true,
            pagination: {
                el: this.$refs.pagination,
                clickable: true,
            },
            navigation: {
                nextEl: this.$refs.next,
                prevEl: this.$refs.prev,
            }
        })
    }
});
