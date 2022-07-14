import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((app, store) => {
    app.component("index-banner-field", IndexField);
    app.component("detail-banner-field", DetailField);
    app.component("form-banner-field", FormField);
});
