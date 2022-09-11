<template>
    <DefaultField
        :field="currentField"
        :full-width-content="currentField.fullWidth"
        :show-help-text="false"
    >
        <template #field :class="{ 'border-danger border': hasErrors }">
            <div
                class="shadow relative border rounded border-gray-300 attach-many-container"
                :class="{ 'border-danger border': hasErrors }"
            >
                <div v-if="currentField.showToolbar" class="flex items-center">
                    <div class="flex items-center w-full">
                        <div
                            v-if="showDropdown"
                            class="fixed inset-0"
                            @click="showDropdown = false"
                        ></div>
                        <input
                            @focus="showDropdown = true"
                            v-model="search"
                            type="search"
                            :placeholder="__('Start typing...')"
                            class="w-full form-control form-input"
                        />
                    </div>
                </div>
                <div
                    v-if="showDropdown"
                    class="divide divide-gray-100 shadow-lg rounded z-20 absolute bg-white bottom-full left-0 right-0 border border-gray-100 dark:border-gray-700 overflow-scroll"
                    :style="{ height: currentField.height }"
                >
                    <div
                        v-if="loading"
                        class="flex justify-center"
                        :style="{ height: currentField.height }"
                    >
                        <loader />
                    </div>
                    <CheckboxWithLabel
                        v-else
                        class="p-2 px-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700"
                        v-for="resource in resources"
                        :key="resource.value"
                        :checked="selected.includes(resource.value)"
                        @input="toggle($event, resource.value)"
                    >
                        <div class="flex flex-col">
                            <div>{{ resource.display }}</div>
                            <div v-if="currentField.withSubtitles">
                                <span v-if="resource.subtitle">{{
                                    resource.subtitle
                                }}</span>
                                <span v-else>{{
                                    __("No additional information...")
                                }}</span>
                            </div>
                        </div>
                    </CheckboxWithLabel>
                </div>

                <div
                    v-if="selectedResources.length"
                    class="border-t border-gray-300 divide-y divide-gray-100"
                >
                    <div
                        class="p-2 px-4 flex flex-row justify-between items-center gap-4"
                        v-for="item in selectedResources"
                    >
                        <div class="truncate">{{ item.display }}</div>
                        <button
                            class="text-gray-400"
                            @click.prevent="toggle($event, item.value)"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <HelpText class="error-text mt-2 text-danger" v-if="hasErrors">
                {{ firstError }}
            </HelpText>

            <div
                class="help-text mt-3 w-full flex justify-between"
                :class="{ invisible: loading }"
            >
                <span v-if="currentField.showCounts">
                    {{ selected.length }} / {{ available.length }}
                </span>

                <span v-if="currentField.helpText">
                    <HelpText class="help-text">
                        {{ currentField.helpText }}
                    </HelpText>
                </span>

                <span
                    v-if="currentField.showRefresh"
                    @click="refresh($event)"
                    class="cursor-pointer"
                >
                    <span>{{ __("Refresh") }}</span>
                </span>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { DependentFormField, HandlesValidationErrors } from "laravel-nova";

export default {
    mixins: [DependentFormField, HandlesValidationErrors],

    props: ["resourceName", "resourceId", "field"],

    data() {
        return {
            search: null,
            selected: [],
            selectingAll: false,
            available: [],
            loading: true,
            showDropdown: false,
        };
    },

    methods: {
        setInitialValue() {
            this.retrieveData();
        },
        retrieveData(keepSelected = false) {
            let baseUrl = "/nova-vendor/nova-attach-many/";

            if (this.resourceId) {
                Nova.request(
                    baseUrl +
                        this.resourceName +
                        "/" +
                        this.resourceId +
                        "/attachable/" +
                        this.field.attribute
                ).then((data) => {
                    if (keepSelected) {
                        this.selected = _.intersection(
                            this.selected,
                            _.map(data.data.available, "value")
                        );
                    } else {
                        this.selected = data.data.selected || [];
                    }
                    this.available = data.data.available || [];
                    this.loading = false;
                });
            } else {
                Nova.request(
                    baseUrl +
                        this.resourceName +
                        "/attachable/" +
                        this.field.attribute
                ).then((data) => {
                    this.available = data.data.available || [];
                    this.loading = false;
                });
            }
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || []);
        },

        toggle(event, id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(
                    (selectedId) => selectedId != id
                );
            } else {
                this.selected.push(id);
            }
            this.search = null;
        },

        refresh(event) {
            this.loading = true;
            this.retrieveData(true);
        },

        clearSearch() {
            this.selectingAll = false;
            this.search = null;
        },
    },
    computed: {
        resources: function () {
            if (this.search == null) {
                return this.available;
            }

            return this.available.filter((resource) => {
                return resource.display
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
            });
        },
        selectedResources: function () {
            return this.available.filter((resource) => {
                return this.selected.includes(resource.value);
            });
        },
        hasErrors: function () {
            return this.errors.errors.hasOwnProperty(this.field.attribute);
        },
        firstError: function () {
            return this.errors.errors[this.field.attribute][0];
        },
    },
    watch: {
        search: {
            handler: function (search) {},
        },
        selected: {
            handler: function (selected) {
                this.value = JSON.stringify(selected);
            },
            deep: true,
        },
    },
};
</script>
