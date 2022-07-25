@if ($src && $srcset)
    <img {{ $attributes }} src="{{ $src }}" srcset="{{ $srcset }}" sizes="1px"
        x-init="$nextTick(() => {
            $el.setAttribute('sizes', (Math.ceil($el.clientWidth || $el.parentElement.clientWidth || $el.parentElement.parentElement.clientWidth || 1) / window.innerWidth * 100) + 'vw');
        })" />
@endif
