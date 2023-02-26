<template x-if="instance.strand">
    <div class="relative w-6 text-gray" :style="`color: ${instance.strand.color}`">
        <div style="background-color: currentColor;" class="peer h-6 w-6 rounded-full"></div>
        <div class="type-xs-mono absolute left-1/2 top-full translate-y-2 -translate-x-1/2 transform whitespace-nowrap rounded py-1 px-3 opacity-0 transition duration-500 peer-hover:opacity-100 pointer-events-none"
            style="background-color: currentColor;">
            <div class="absolute left-1/2 bottom-full h-4 w-4 -translate-x-1/2 transform border-8 border-transparent border-b-gray"
                style="border-bottom-color: currentColor;">
            </div>
            <span class="text-black" x-text="instance.strand.name"></span>
        </div>
    </div>
</template>
