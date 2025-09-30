import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
// import _ from "lodash";
// window._ = _;

// import Alpine from "alpinejs";

import intersect from "@alpinejs/intersect";
import carousel from "./carousel.js";
import focus from "@alpinejs/focus";

import Swiper from "swiper";
import "swiper/css";
window.Swiper = Swiper;

import lottie from "lottie-web";

window.lottie = lottie;

// Register Alpine plugins and data whether Alpine is already loaded or not
function registerAlpineStuff() {
    window.Alpine.plugin(intersect);
    window.Alpine.plugin(focus);
    window.Alpine.data("carousel", carousel);
}

if (window.Alpine) {
    registerAlpineStuff();
} else {
    document.addEventListener("livewire:initialized", registerAlpineStuff);
}
// Alpine.plugin(intersect);
// Alpine.plugin(focus);

// window.Alpine = Alpine;

// Alpine.start();
Livewire.start();

import { format, compareAsc } from "date-fns";
window.format = format;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// import axios from "axios";
// window.axios = axios;

// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
