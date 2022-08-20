<template>
    <div
        class="w-12 h-12 flex justify-center items-center bg-black p-1 rounded"
        v-html="fieldValue"
    ></div>
</template>

<script>
export default {
    props: ["resourceName", "field"],

    computed: {
        fieldValue() {
            return this.field.displayedAs || this.field.value;
        },
    },
};
</script>
