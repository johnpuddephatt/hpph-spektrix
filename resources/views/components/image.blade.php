@if ($src && $srcset)
    <img {{ $attributes }} src="{{ $src }}" srcset="{{ $srcset }}" sizes="1px" x-data="{}"
        onload="if(this.getAttribute('sizes') == '1px') { this.setAttribute('sizes', '{{ $width ?? null }}' || (Math.ceil(this.clientWidth || this.parentElement.clientWidth || this.parentElement.parentElement.clientWidth || 1) / window.innerWidth * 100) + 'vw'); }" />
@endif
