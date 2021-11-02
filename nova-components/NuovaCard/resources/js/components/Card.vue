<template>
    <div class="akka-agenda">
        <div class="flex justify-between">
            <heading class="mb-6">Calendario</heading>
            <button class="btn btn-default btn-primary bg-primary-30%" @click="createExtraordinary">
                {{ __('Extraordinary manutention') }}
            </button>
        </div>

        <span class="hidden">{{lang}}</span>

        <div class="card py-6 px-6">
            <FullCalendar ref="fullCalendar" :options="calendarOptions" >
                <template v-slot:eventContent='arg'>
                    <font-awesome-icon :icon="`fa-solid ${getIcon(arg.event)}`" /><i class="mx-2">{{ arg.event.title }}</i>
                    <button class="btn btn-default btn-primary bg-primary-30%" @click="goTo(arg.event.extendedProps)">{{ __('Take Charge') }}</button>
                </template>
            </FullCalendar>
        </div>

    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list';
import itLocale from '@fullcalendar/core/locales/it';

export default {
    metaInfo() {
        return {
            title: 'Calendar',
        }
    },
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data() {
        return {
            calendarOptions: {
                plugins: [listPlugin, dayGridPlugin],
                initialView: 'listMonth',
                timeZone: 'UTC',
                locales: [itLocale],
                // // customize the button names,
                // // otherwise they'd all just say "list"
                views: {
                    listWeek: {buttonText: this.__('Settimana')},
                    // listMonth: {buttonText: 'list month'},
                },
                headerToolbar: {
                    left: 'title',
                    center: 'today prev,next',
                    right: 'listWeek,listMonth,dayGridMonth'
                },
                // dayMaxEvents: 0,
                dayMaxEventRows: true,
                events: '/nova-vendor/agenda/events',
                eventColor: "#ddd"
            }
        }
    },
    computed: {
        lang() {
            this.calendarOptions.locale = Nova.config.locale;
            return Nova.config.locale;
        }
    },
    mounted() {
        //
    },
    methods: {
        createExtraordinary() {
            this.$router.push(`/resources/maintenances/new`);
        },
        goTo(activity){
            if(activity.type.includes('maintenance')){
                this.$router.push(`/resources/maintenances/${activity.activitable_id}/edit?viaResource=components&viaRelationship=maintenances&viaResourceId=${activity.element_id}`);
            } else {
                this.$router.push(`/resources/machines/${activity.machine_id}?tab=2`);
            }
        },
        getIcon(event) {
          return event.extendedProps.type.includes('maintenance') ? 'fa-screwdriver-wrench' : 'fa-temperature-half';
        },
        getColor(event) {
            if(event.active) {
                if (moment().isAfter(moment(event.start))) {
                    return "bg-red-600"
                }

                if (moment(event.start).isSameOrBefore(moment().add(5, 'day'))) {
                    return "bg-yellow-500"
                }
            }

            return '';
        },
    }
}
</script>

<style>
/* Scoped Styles */
</style>
