import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((Vue, router) => {
    Vue.component('detail-akka-nova-dependency-container', DetailField);
    Vue.component('form-akka-nova-dependency-container', FormField);
})
