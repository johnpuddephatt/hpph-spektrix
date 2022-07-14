<template>
    <div class="hpph-field">
        <input
            class="bg-yellow-200 font-bold px-4 py-4 text-xl text-black w-full focus-visible:outline-none"
            placeholder="Type a heading..."
            v-model="heading"
        />
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: {
        resourceName: { required: false, type: String },
        resourceId: { required: false, type: String },
        field: { required: false, type: String },
    },

    data: {
        heading: null,
    },

    mounted() {
        this.heading = this.field.value;
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, this.heading);
        },
    },
};
</script>
