import IndexField from './components/IndexField.vue'
import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'
import ImageFormField from "./components/ImageFormField";

Nova.booting((Vue, router, store) => {
    Vue.component('index-akka-date', IndexField)
    Vue.component('detail-akka-date', DetailField)
    Vue.component('form-akka-date', FormField)
    Vue.component('form-akka-image', ImageFormField)
})
