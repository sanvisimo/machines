<template>
    <div>
        <div class="flex justify-between">
            <heading class="mb-6">Calendario</heading>
            <button>{{ __('Extraordinary manutention') }}</button>
        </div>

        <div class="card py-6 px-6">
            <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        </div>

    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list';


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

                // // customize the button names,
                // // otherwise they'd all just say "list"
                views: {
                    listMia: {
                        type: 'list',
                        visibleRange: {
                            start: "2021-10-01",
                            end: "2021-11-10"
                        },
                        buttonText: '4 ada'
                    },
                    listDay: { buttonText: 'list day' },
                    listWeek: { buttonText: 'list week' },
                    listMonth: { buttonText: 'list month' }
                },

                headerToolbar: {
                    left: 'title',
                    center: '',
                    right: 'listDay,listWeek,listMia,listMonth'
                },
                events: 'https://fullcalendar.io/demo-events.json'
            }
        }
    },
    mounted() {
        //
    },
}
</script>

<style>
/* Scoped Styles */
</style>
