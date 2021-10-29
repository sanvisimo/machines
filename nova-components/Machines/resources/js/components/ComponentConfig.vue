<template>
    <div>
        <div class="flex flex-row">
            <button
                class="py-5 px-8 border-b-4 focus:outline-none tab self-center"
                :class="[activeTab === tab.name ? 'text-grey-black font-bold border-primary-30%': 'text-grey font-semibold border-40']"
                v-for="(tab, key) in tabs"
                :key="key"
                @click="handleTabClick(tab, $event)"
            >{{ tab.name }}
            </button>

            <div class="flex-1 border-b-42 border-40"></div>
        </div>
        <div
            v-for="(tab, index) in tabs"
            v-show="tab.name === activeTab"
            :label="tab.name"
            :key="'related-tabs-fields' + index"
        >
            <div>
                <div v-for="(vibration) in tab.vibrations" class="border-b-4 my-3 px-3">
                    <h2 class="text-90 font-normal text-2xl mb-3">C{{ tab.index + 1 }} - B{{ vibration }}</h2>
                    <component-config-form :component-id="tab.id" :ref="`vibration-C${tab.index}-B${vibration}`" />
                </div>
                <div v-for="(article) in tab.articles" class="border-b-4 my-3 px-3">
                    <h2 class="text-90 font-normal text-2xl mb-3">C{{ tab.index + 1 }} - P{{ article }}</h2>
                    <component-config-form :component-id="tab.id" :ref="`position-C${tab.index}-P${article}`" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Title from "./Title";
import Create from '../../../../../nova/resources/js/views/Create'

export default {
    props: ['resourceName', 'resourceId', 'panel'],
    components: {
        Title,
        Create
    },
    data () {
        return {
            tabs: null,
            activeTab: "",
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async submitForms(id){
            for(let tab in this.tabs){
                for(let i = 0; i < this.tabs[tab].vibrations; i++) {
                    const key = `vibration-C${this.tabs[tab].index}-B${i+1}`;
                    await this.$refs[key][0].submitForm(id);
                }
                for(let i = 0; i < this.tabs[tab].articles; i++) {
                    const key = `position-C${this.tabs[tab].index}-P${i+1}`;
                    await this.$refs[key][0].submitForm(id);
                }
            }
          // this.$refs.positions.submitForm();
        },
        async fetchData () {
            let tabs = {}
            const { data } = await Nova.request().get(`/nova-vendor/machines/components-config/${this.resourceId}`);
            data.components.forEach((component, index) => {
                if (!tabs.hasOwnProperty(component.name)) {
                    tabs[component.name] = {
                        id: component.id,
                        name: component.name,
                        index,
                        init: false,
                        vibrations: component.vibrations,
                        articles: component.temperature + component.pressure + component.payload
                    }
                }

                tabs[component.name].fields = {
                    ...tabs[component.name].fields,
                    ...component
                };
            })

            this.tabs = tabs
            this.handleTabClick(tabs[Object.keys(tabs)[0]]);
        },
        handleTabClick(tab, event) {
            tab.init = true
            this.activeTab = tab.name
        },
    }
}
</script>
