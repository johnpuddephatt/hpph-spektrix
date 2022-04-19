<template>
    <!-- <div> -->
    <default-field
        @keydown.stop
        :field="field"
        :errors="errors"
        :fullWidthContent="true"
        class="editor-js-wrapper"
    >
        <template #field>
            <div
                :id="'editor-js-' + this.field.attribute"
                class="editor-js text-base"
            ></div>
        </template>
    </default-field>
    <!-- </div> -->
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value;

            let self = this;
            let currentContent = self.field.value
                ? JSON.parse(self.field.value)
                : self.field.value;

            const editor = NovaEditorJS.getInstance(
                {
                    /**
                     * Wrapper of Editor
                     */
                    holderId: "editor-js-" + self.field.attribute,

                    /**
                     * This Tool will be used as default
                     */
                    initialBlock: self.field.editorSettings.initialBlock,

                    /**
                     * Default placeholder
                     */
                    placeholder: self.field.editorSettings.placeholder,

                    /**
                     * Enable autofocus
                     */
                    autofocus: self.field.editorSettings.autofocus,

                    /**
                     * Initial Editor data
                     */
                    data: currentContent,

                    /**
                     * Min height of editor
                     */
                    minHeight: 35,

                    onReady: function () {},
                    onChange: function () {
                        editor.save().then((savedData) => {
                            self.handleChange(savedData);
                        });
                    },
                },
                self.field
            );
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || "");
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = JSON.stringify(value);
        },
    },
};
</script>

<style>
.editor-js-wrapper {
    /* width: 60%; */
    /* background-color: #f9fafb; */
    /* padding: 2rem; */
    /* padding-left: calc(20% + 2rem); */
    /* color: #7c858e; */
}

.editor-js {
    width: calc(100% + 15px) !important;
}

.ce-block__content,
.ce-toolbar__content {
    max-width: 720px !important;
    margin: 0 !important;
}
.cdx-block {
    max-width: 100% !important;
}

.ce-paragraph {
    line-height: 2em !important;
}
</style>
