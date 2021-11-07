import APanels from './components/APanels.vue'
import Breadcrumb from "./components/Breadcrumb";

Nova.booting((Vue, router, store) => {
    Vue.component('akka-panels', APanels);
    Vue.component('akka-breadcrumb', Breadcrumb);
})
