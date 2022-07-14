<template>
    <div class="hpph-field">
        <banner-image
            thumbnail-classes="w-full h-96"
            :initial-value="field.value"
            @changed="media = $event"
        />
        <div
            class="bg-stone-200 text-black py-8 px-4 flex flex-col md:flex-row gap-8 md:gap-16"
        >
            <h1 class="font-bold text-5xl w-2/5">
                {{ title }}
            </h1>
            <textarea
                @input="updateHeight($event.target)"
                ref="introductionTextarea"
                class="resize-none border-none outline-none bg-transparent flex-1 font-bold text-2xl"
                placeholder="placeholder"
                v-model="introduction"
            >
            </textarea>
        </div>
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import BannerImage from "../../../shared/BannerImage.vue";

export default {
    mixins: [FormField, HandlesValidationErrors],

    components: { BannerImage },

    props: {
        resourceName: { required: false, type: String },
        resourceId: { required: false, type: String },
        field: { required: false, type: String },
    },

    data: {
        title: null,
        introduction:
            "What does Lorem ipsum dolor sit amet consectetuer adipiscing elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore mean in English?",
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, JSON.stringify(this.media));
        },

        findPageTitle() {
            return document.querySelector('[dusk="title"]').value;
        },

        updateHeight(element) {
            element.style.height = "auto";
            element.scrollHeight + "px";
        },
    },

    mounted() {
        this.updateHeight(this.$refs.introductionTextarea);

        this.title = this.findPageTitle();

        // setInterval(() => {
        //     this.title = this.findPageTitle();
        // }, 5000);

        Nova.$on("title-change", (message) => {
            this.title = message;
        });
    },
};
</script>
