@if ($location)
    <span class="type-xs-mono overflow-hidden text-ellipsis whitespace-nowrap">
        @svg('map-marker', "h-4 w-4 inline-block mr-1 { $color }"){{ $location }}
    </span>
@endif
