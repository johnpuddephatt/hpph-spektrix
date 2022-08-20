<template>
    <PanelItem :index="index" :field="field">
        <template v-slot:value>
            <div
                v-html="field.value"
                class="bg-black py-12 flex items-center justify-center rounded"
            ></div
        ></template>
    </PanelItem>
</template>

<script>
export default {
    props: ["index", "resource", "resourceName", "resourceId", "field"],
};
</script>
