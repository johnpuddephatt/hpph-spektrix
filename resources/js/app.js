// import { getQuarter } from "date-fns";

import "./bootstrap";

window.addEventListener("scroll", function (e) {
    if (document.documentElement.scrollTop == 0) {
        const event = new CustomEvent("scrolled", {
            detail: false,
            bubbles: true,
        });
        document.body.dispatchEvent(event);
        window.hasScrolled = false;
    }

    if (document.documentElement.scrollTop > 0 && !window.hasScrolled) {
        const event = new CustomEvent("scrolled", {
            detail: true,
            bubbles: true,
        });
        document.body.dispatchEvent(event);
        window.hasScrolled = true;
    }
});
