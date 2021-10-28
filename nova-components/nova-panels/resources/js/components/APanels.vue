<template>
    <div>
        <div class=""></div>
        <div>
            <div class="flex flex-row">
                <h4 class="text-90 font-normal text-2xl title px-8 border-b-2 border-40">{{ panel.name }}</h4>
                <div class="flex-1 border-b-2 border-40"></div>
                <div class="flex flex-row">
                    <button
                        class="py-5 px-8 border-b-2 focus:outline-none tab"
                        :class="[activeTab === tab.name ? 'text-grey-black font-bold border-primary': 'text-grey font-semibold border-40']"
                        v-for="(tab, key) in tabs"
                        :key="key"
                        @click="handleTabClick(tab, $event)"
                    >{{ tab.name }}
                    </button>
                </div>
                </div>
                <div
                    v-for="(tab, index) in tabs"
                    v-if="tab.init"
                    v-show="tab.name === activeTab"
                    :label="tab.name"
                    :key="'related-tabs-fields' + index"
                >
                    <div>
<!--                        <router-link-->
<!--                            v-if="resource.authorizedToUpdate"-->
<!--                            data-testid="edit-resource"-->
<!--                            dusk="edit-resource-button"-->
<!--                            :to="{ name: 'edit', params: { id: resource.id } }"-->
<!--                            class="btn btn-default btn-icon bg-primary"-->
<!--                            :title="__('Edit')"-->
<!--                        >-->
<!--                            <icon-->
<!--                                type="edit"-->
<!--                                class="text-white"-->
<!--                                style="margin-top: -2px; margin-left: 3px"-->
<!--                            />-->
<!--                        </router-link>-->
                        <div v-for="(pan, index) in tab.fields" class="my-4">
                            <component
                                :is="pan.component"
                                :name="index"
                                :panel="pan"
                                :resourceId="resourceId"
                                resourceName="machines"
                                :resource="resource"
                            />
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import BehavesAsPanel from 'laravel-nova/src/mixins/BehavesAsPanel'

export default {
    mixins: [BehavesAsPanel],
    data() {
        return {
            tabs: null,
            activeTab: "",
            pans: null
        };
    },
    mounted() {
        let tabs = {}

        tabs = [
            {id: 0, name: this.__('Overview'), init: true, fields: {}},
            {id: 1, name: this.__('Calendar'), init: false, fields: {}},
            {id: 2, name: this.__('Control Plan'), init: false, fields: {}},
        ]

        this.panel.fields.forEach(field => {
            if (!tabs[field.tab].fields.hasOwnProperty(field.pan)) {
                tabs[field.tab].fields[field.pan] = {
                    name: field.pan,
                    init: false,
                    listable: field.listableTab,
                    component: this.componentName(field),
                    fields: []
                }
            }

            tabs[field.tab].fields[field.pan].fields.push(field);
        })

        this.tabs = tabs;
        this.handleTabClick(tabs[Object.keys(tabs)[0]]);
    },
    methods: {
        /**
         * Handle the actionExecuted event and pass it up the chain.
         */
        actionExecuted() {
            this.$emit("actionExecuted");
        },

        handleTabClick(tab, event) {
            tab.init = true
            this.activeTab = tab.name
        },

        componentName(field) {
            return field.listableTab ? 'relationship-panel' : field.panComponent
        },

        panelName(panel) {
            switch(panel) {
                case "Accordion":
                    return "akka-accordion"
                default:
                    return 'panel'
            }
        }
    }
}
</script>

<style>
.title  {
    padding-top: 1.25rem;
    padding-bottom: 1.25rem;
}
</style>
