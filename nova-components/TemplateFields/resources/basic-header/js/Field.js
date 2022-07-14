import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((app, store) => {
    app.component("index-basic-header-field", IndexField);
    app.component("detail-basic-header-field", DetailField);
    app.component("form-basic-header-field", FormField);
});
