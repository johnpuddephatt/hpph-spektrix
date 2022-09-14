<div class="@if ($_align ?? false == 'right') lg:w-1/2 lg:ml-[50%] max-w-2xl mx-0 @else max-w-6xl @endif container">
    <a class="mb-5 inline-block rounded bg-yellow p-4" href="{{ $file->url }}"><span
            class="type-subtitle">{{ $title }}</span>&nbsp;
        <span class="type-label">
            @if ($file->size > 1048576)
                [{{ round($file->size / 1048576, 1) }}MB]
            @else
                [{{ round($file->size / 1024, 0) }}KB]
            @endif
        </span></a>
</div>
