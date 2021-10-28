import Accordion from './components/Accordion.vue'

Nova.booting((Vue, router, store) => {
    Vue.component('akka-accordion', Accordion);
})
