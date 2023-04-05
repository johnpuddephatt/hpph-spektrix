<template x-if="instance.strand">

    <div class="block text-center uppercase font-bold text-xs text-black whitespace-nowrap rounded py-0.5 px-2"
        :style="`background-color: ${instance.strand.color}`" x-text="instance.strand.name">
    </div>
</template>
