import APanels from './components/APanels.vue'

Nova.booting((Vue, router, store) => {
    Vue.component('akka-panels', APanels);
})
