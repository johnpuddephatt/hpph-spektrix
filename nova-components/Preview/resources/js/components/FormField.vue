<template>
    <div class="flex flex-row w-16">
        <div class="flex-shrink w-full relative">
            <iframe
                class="w-full block"
                ref="iframe"
                @load="update()"
                :srcdoc="`
                  <html>
                    <head>
                      <link rel='stylesheet' href='${field.stylesheet}' />
                      <script type='module'>
                        window.addEventListener('message', (event) => {
                          document.body.innerHTML = event.data;
                          window.parent.postMessage('updated', '*');
                        })
                      </script>
                    </head>
                    <body>
                    </body>
                  </html>`"
            >
            </iframe>
        </div>

        <div class="bg-white border-l overflow-hidden" style="width: 25%">
            <div class="pt-4 bg-gray-50 border-b">
                <ul class="font-semibold flex flex-row px-2">
                    <li class="py-2 px-4 border-b border-primary-300">
                        Content
                    </li>
                    <li class="py-2 px-4">Settings</li>
                </ul>
            </div>
            <div
                class="py-4 fields relative"
                style="
                    width: 125%;
                    margin-left: -0.25rem;
                    margin-right: -0.25rem;
                "
            >
                <component
                    v-for="(item, index) in field.fields"
                    :key="index"
                    :is="'form-' + item.component"
                    :resource-name="resourceName"
                    :resource-id="resourceId"
                    :ref="'field-' + item.attribute"
                    fullWidthContent="true"
                    @input="onInput"
                    :field="item"
                    :errors="errors"
                    :mode="mode"
                    :show-help-text="item.helpText != null"
                    :class="{
                        'remove-bottom-border':
                            index == field.fields.length - 1,
                    }"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    data() {
        return {
            data: new FormData(),
            preview: null,
        };
    },

    mounted() {
        window.addEventListener(
            "message",
            () => {
                this.setHeight(this.$refs.iframe);
            },
            false
        );
    },

    methods: {
        setHeight(iframe) {
            iframe.style.height =
                iframe.contentWindow.document.body.scrollHeight + "px";
        },

        // setInitialValue() {
        //     this.value = this.field.value || "";
        // },

        fill(formData) {
            // console.log(this.$parent);
            // for (var pair of formData.entries()) {
            //     console.log(pair[0] + ", " + pair[1]);
            // }
            let myFormData = new FormData();
            _.each(this.field.fields, (field) => {
                if (field.fill) {
                    field.fill(myFormData);
                }
            });

            // NOT WORKING!
        },

        onInput: _.debounce(function debounceRead() {
            this.update();
        }, 150),

        update() {
            _.each(this.field.fields, (field) => {
                if (field.fill) {
                    field.fill(this.data);
                }
            });

            let myFormData = this.data;
            myFormData.append("_view", this.field.view);

            fetch("/nova-vendor/view/view", {
                method: "post",
                body: myFormData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            })
                .then((response) => response.text())
                .then((data) => {
                    this.$refs.iframe.contentWindow.postMessage(data, "*");
                    this.setHeight(this.$refs.iframe);
                });
        },
    },
};
</script>

<style>
.fields .md\:px-8 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.fields .pb-5 {
    padding-bottom: 0.5rem;
}

.fields label {
    font-weight: bold;
}
</style>
