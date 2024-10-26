<template x-if="instance.strand && instance.strand.show_in_booking_path">
    <div class="block text-center uppercase font-bold text-xs text-black whitespace-nowrap rounded py-0.5 px-2"
        :style="`background-color: ${instance.strand.color}`" x-text="instance.strand.name">
    </div>
</template>
