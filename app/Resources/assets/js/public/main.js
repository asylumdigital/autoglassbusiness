import Alpine from "alpinejs";

import { PartnerCarousel } from "./components/carousel/partner";
import { Carousel } from "./components/carousel/content";

Alpine.data('partner', PartnerCarousel);
Alpine.data('carousel', Carousel);

Alpine.start();
