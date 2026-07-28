<template x-for="strand in (instance.strands || []).filter(s => s.show_in_booking_path)" :key="strand.id">
    <div class="block text-center uppercase font-bold text-xs text-black whitespace-nowrap rounded py-0.5 px-2"
        :style="`background-color: ${strand.color}`" x-text="strand.name">
    </div>
</template>
