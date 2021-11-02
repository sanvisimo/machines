import Calendar from "./components/Tool";

Nova.booting((Vue, router, store) => {
    Vue.component('akka-calendar', Calendar);

    router.addRoutes([
        {
            name: 'agenda',
            path: '/agenda',
            component: Calendar,
        },
    ])
})
