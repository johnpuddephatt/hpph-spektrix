{{--
    A single membership, placed on a page on its own. The editor picks one of two
    styles on the block; each lives in its own partial under single-membership/.

    Renders nothing if the membership has been removed or has dropped out of the
    Spektrix import (the enabled global scope hides it), rather than erroring.
--}}

@if ($layout->membership)
    @push('webComponents', '#spektrix-memberships')

    @include('blocks.single-membership.' . $layout->variant, [
        'layout' => $layout,
        'membership' => $layout->membership,
        'dark' => $dark ?? false,
    ])
@endif
