// import { getQuarter } from "date-fns";

import { forEach } from "lodash";
import "./bootstrap";
import dialogPolyfill from "dialog-polyfill";

window.addEventListener("DOMContentLoaded", () => {
    console.log(typeof HTMLDialogElement);
    if (typeof HTMLDialogElement !== "function") {
        console.log("polyfilling dialog");
        const dialogs = document.querySelectorAll("dialog");
        forEach(dialogs, (dialog) => {
            dialogPolyfill.registerDialog(dialog);
        });
    }

    if (!CSS.supports("aspect-ratio", "16 / 9")) {
        const images = document.querySelectorAll(".aspect-video");
        forEach(images, (image) => {
            image.style.height = image.clientWidth * (9 / 16) + "px";
        });
    }
});

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

Livewire.on("scrollToTop", () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behaviour: "smooth",
    });
});
