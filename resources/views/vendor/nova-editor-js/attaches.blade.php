<a class="max-w-[50ch] mt-12 mb-5 !no-underline inline-block rounded bg-yellow p-4"
    href="{{ Storage::url($file['url']) }}"><span class="type-regular">{{ $title }}</span>&nbsp;
    <span class="type-xs-mono">
        @if ($file['size'] > 1048576)
            [{{ round($file['size'] / 1048576, 1) }}MB]
        @else
            [{{ round($file['size'] / 1024, 0) }}KB]
        @endif
    </span></a>
