import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((Vue, router, store) => {
  Vue.component('index-control-plan-field', IndexField);
  Vue.component('detail-control-plan-field', DetailField);
  Vue.component('form-control-plan-field', FormField);
})
