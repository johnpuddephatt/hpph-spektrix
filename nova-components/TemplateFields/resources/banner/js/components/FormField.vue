<template>
    <div class="hpph-field">
        <banner-image
            thumbnail-classes="w-full h-96"
            :initial-value="field.value"
            @changed="media = $event"
        />
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";
import BannerImage from "../../../shared/BannerImage.vue";

export default {
    components: {
        BannerImage,
    },

    mixins: [FormField, HandlesValidationErrors],

    props: {
        resourceName: { required: false, type: String },
        resourceId: { required: false, type: String },
        field: { required: false, type: String },
    },

    data: {
        media: null,
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, JSON.stringify(this.media));
        },
    },
};
</script>
