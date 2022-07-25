<div x-cloak x-data="carousel" x-init="slideCarousel" class="bg-yellow pb-36">
    <div id="carousel-wrapper" x-intersect:enter="window.addEventListener('scroll', slideCarousel, false)"
        x-intersect:leave="window.removeEventListener('scroll', slideCarousel)">
        <div class="images">
            @foreach ([1, 2, 3, 4, 5] as $image)
                <img class="absolute left-0 block w-[33.3vw] origin-center rounded-3xl"
                    src="https://loremflickr.com/360/450" />
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("carousel", () => ({
            slideCarousel() {
                let ticking = false;
                let lastKnownScrollPosition = window.scrollY;
                let wrapper = document.getElementById("carousel-wrapper");
                let images = wrapper.querySelectorAll("img");
                let max_swing = window.innerWidth / 3;
                let scrollContainer = wrapper.querySelector(".images");
                let scales = [];
                let translates = [];
                let columns = 3;
                scrollContainer.style.height = window.innerWidth / 3 * (450 / 360) + "px";

                if (!ticking) {
                    let scrollContainer = wrapper.querySelector(".images");
                    if (!scrollContainer.clientHeight) return false;
                    let swing_percent =
                        (lastKnownScrollPosition -
                            scrollContainer.offsetParent.offsetTop -
                            scrollContainer.offsetTop -
                            scrollContainer.clientHeight / 2 +
                            window.innerHeight / 2) /
                        scrollContainer.clientHeight;

                    let swing = swing_percent * max_swing;
                    images.forEach((img, key) => {
                        translates[key] =
                            ((columns - images.length) / 2 + key) * img
                            .clientWidth;

                        let distance_from_centre =
                            translates[key] +
                            img.clientWidth / 2 +
                            swing -
                            window.innerWidth / 2;

                        scales[key] = 1 - Math.abs(distance_from_centre / window
                            .innerWidth);

                        let adjustment =
                            ((Math.abs(distance_from_centre) *
                                    distance_from_centre) /
                                window.innerWidth) *
                            0.45 -
                            key * 30;
                        translates[key] = translates[key] - adjustment;
                    });
                    window.requestAnimationFrame(() => {
                        scrollContainer.style.transform = `translateX(${swing}px)`;
                        images.forEach((img, key) => {
                            img.style.transform =
                                `translateX(${translates[key]}px) scale(${scales[key]})`;
                        });
                        ticking = false;
                    });
                    ticking = true;
                }
            },
            // translateSection(lastKnownScrollPosition, wrapper, images) {

            // }
        }));
    });
</script>
