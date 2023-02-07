<div x-ref="spacer" class="transition duration-1000" :class="isActive ? 'bg-black' : 'bg-sand'" x-data="{
    isActive: false,
    galleryScroll() {
        let percentage = (($refs.sticky.offsetTop - $refs.spacer.offsetTop) / ($refs.spacer.clientHeight - $refs.sticky.clientHeight));
        let maxTransform = $refs.scroller.clientWidth - document.documentElement.clientWidth + 8;
        $refs.scroller.style.transform = 'translateX(-' + (percentage * maxTransform) + 'px)';
    }
}"
    x-init="$el.style.height = $refs.scroller.clientWidth + 'px'">
    <div x-ref="sticky" class="first-letter: w-full overflow-hidden sticky top-[12.5vh] p-2 pb-0 bg-black"
        x-intersect:enter.full="isActive = true;document.addEventListener('scroll',galleryScroll)"
        x-intersect:leave.full="isActive = false;document.removeEventListener('scroll',galleryScroll)">
        <div x-ref="scroller" class="inline-flex leading-none gap-2">
            @foreach ($images as $image)
                {!! $image->img('thumb', ['class' => 'h-[65vh]  w-auto max-w-none block'])->toHtml() !!}
            @endforeach
        </div>
    </div>
</div>
