import Alpine from "alpinejs";

import { Carousel } from "./components/carousel/content";

Alpine.data('carousel', Carousel);

Alpine.start();

window.addEventListener('message', (e) => {
    // always verify the sender
    if (e.origin !== 'https://cloud.email.autoglass.co.uk') return;

    console.log(e);
    // const data = e.data;
    // if (data?.type !== 'resize') return;

    // document.querySelector('#newBusinessEnquiry iframe').style.height = data.height + 'px';
});
