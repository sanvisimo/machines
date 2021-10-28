import IndexField from './components/IndexField.vue'
import DetailField from './components/DetailField.vue'
import FormField from './components/FormField.vue'

Nova.booting((Vue, router, store) => {
    Vue.component('index-akka-date', IndexField)
    Vue.component('detail-akka-date', DetailField)
    Vue.component('form-akka-date', FormField)
})
