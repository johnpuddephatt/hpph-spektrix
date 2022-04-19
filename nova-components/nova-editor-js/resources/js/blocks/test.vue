<template>
    <div class="my-16 bg-gray-100 p-4">
        <h3
            contenteditable="true"
            @input="title = $event.currentTarget.innerHTML"
            v-html="title"
            class="mb-2 text-xl focus-visible:outline-none"
        ></h3>
        <div
            contenteditable="true"
            @input="body = $event.currentTarget.innerHTML"
            v-html="body"
            class="focus-visible:outline-none"
        ></div>
    </div>
</template>

<script>
export default {
    props: ["initialValues"],
    data() {
        return {
            title: this.initialValues.title ?? "Your title",
            body: this.initialValues.body ?? "Body goes here",
        };
    },
    methods: {
        getTheData() {
            return this.$data;
        },
    },
};
</script>

<style></style>
