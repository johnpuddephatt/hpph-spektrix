export default () => ({
    initialised: false,

    init() {
        this.resizeContainer();
        this.config.images[0].addEventListener("load", () => {
            this.resizeContainer();
        });
        this.slideCarousel(this.config, true);
        setTimeout(this.slideCarousel(this.config, true), 500);
        this.initialised = true;
    },

    config: {
        inView: false,
        wrapper: document.getElementById("carousel-wrapper"),
        images: document
            .getElementById("carousel-wrapper")
            .querySelectorAll("img"),
        scrollContainer: document
            .getElementById("carousel-wrapper")
            .querySelector(".images"),
        max_swing: window.innerWidth / 3,
        // max_swing: 500,
        columns: 3,
        gutter: 30,
    },

    resizeContainer() {
        this.config.scrollContainer.style.height =
            parseInt(getComputedStyle(this.config.images[0]).width, 10) *
                (this.config.images[0].naturalHeight /
                    this.config.images[0].naturalWidth) +
            "px";
    },

    slideCarousel(config, force) {
        if (!config.inView && !force) return null;

        if (!config) {
            var config = this.config;
        }

        let ticking = false;
        let lastKnownScrollPosition = window.scrollY;
        let scales = [];
        let translates = [];

        if (!ticking) {
            let swing_percent =
                (lastKnownScrollPosition -
                    config.scrollContainer.offsetParent.offsetTop -
                    config.scrollContainer.offsetTop -
                    config.scrollContainer.clientHeight / 2 +
                    window.innerHeight / 2) /
                config.scrollContainer.clientHeight;

            let swing = swing_percent * config.max_swing;
            config.images.forEach((img, key) => {
                translates[key] =
                    ((config.columns - config.images.length) / 2 + key) *
                    img.clientWidth;

                let distance_from_centre =
                    translates[key] +
                    img.clientWidth / 2 +
                    swing -
                    window.innerWidth / 2;

                scales[key] = Math.max(
                    1 -
                        Math.abs(
                            distance_from_centre /
                                Math.max(window.innerWidth, 1200)
                        ),
                    0
                );

                let adjustment =
                    ((Math.abs(distance_from_centre) * distance_from_centre) /
                        Math.max(window.innerWidth, 1200)) *
                        0.5 -
                    key * config.gutter;
                translates[key] = translates[key] - adjustment;
            });

            window.requestAnimationFrame(() => {
                config.scrollContainer.style.transform = `translateX(${swing}px)`;
                config.images.forEach((img, key) => {
                    img.style.transform = `translateX(${translates[key]}px) scale(${scales[key]})`;
                });
                ticking = false;
            });
            ticking = true;
        }
    },
});
