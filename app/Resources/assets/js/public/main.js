import Alpine from "alpinejs";

import { ScrollSpy } from './components/jump-links';
import { Carousel } from "./components/carousel/content";

import { YouTube, VimeoPlayer, Local } from "./components/video";

Alpine.data('jump_links', ScrollSpy);
Alpine.data('carousel', Carousel);

Alpine.data('youtube', YouTube);
Alpine.data('direct', Local);
Alpine.data('vimeo', VimeoPlayer);

Alpine.start();

// header height
const headerHeight = () => {
    const header = document.querySelector('header');

    const r = document.querySelector(':root');
    r.style.setProperty('--header-height', `${header.offsetHeight}px`);

}

window.addEventListener('DOMContentLoaded', function() {
    headerHeight();
});

window.addEventListener('resize', headerHeight);
