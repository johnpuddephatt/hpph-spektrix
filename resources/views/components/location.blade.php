@if ($location)
    <span class="type-label overflow-hidden text-ellipsis whitespace-nowrap">
        @svg('map-marker', "h-4 -mt-0.5 w-4 inline-block mr-1 { $color }"){{ $location }}
    </span>
@endif
