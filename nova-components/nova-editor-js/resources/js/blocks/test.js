import TestBlock from "./test.vue";

class Test {
    constructor({ data }) {
        this.data = data ?? {};
        this.wrapper = null;
    }

    static get toolbox() {
        return {
            icon: "🤪",
            title: "Test!",
        };
    }

    render() {
        this.wrapper = document.createElement("div");
        this.wrapper.id = "custom-id";
        let InitialisedTestBlock = Vue.createApp(TestBlock, {
            initialValues: this.data,
        });
        this.mountedTestBlock = InitialisedTestBlock.mount(this.wrapper);
        return this.wrapper;
    }

    save(blockContent) {
        return this.mountedTestBlock.getTheData();
    }

    validate(savedData) {
        return true;
    }
}

NovaEditorJS.booting(function (editorConfig, fieldConfig) {
    if (fieldConfig.toolSettings.test.activated === true) {
        editorConfig.tools.test = {
            class: Test,
            inlineToolbar: fieldConfig.toolSettings.test.inlineToolbar,
            shortcut: fieldConfig.toolSettings.test.shortcut,
        };
    }
});
