import Calendar from "./components/Tool";

Nova.booting((Vue, router, store) => {
    Vue.component('akka-calendar', Calendar);

    router.addRoutes([
        {
            name: 'calendar',
            path: '/calendar',
            component: Calendar,
        },
    ])
})
