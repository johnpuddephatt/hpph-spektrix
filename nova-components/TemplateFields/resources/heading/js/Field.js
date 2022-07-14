import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((app, store) => {
    app.component("index-heading-field", IndexField);
    app.component("detail-heading-field", DetailField);
    app.component("form-heading-field", FormField);
});
