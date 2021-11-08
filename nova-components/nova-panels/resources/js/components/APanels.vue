<template>
    <div>
        <div class=""></div>
        <div>
            <div class="flex flex-row">
                <div class="flex justify-between gap-2 items-center px-8 border-b-2 border-40">
                    <h4 class="text-90 font-normal text-2xl title">{{ panel.name }}</h4>
                    <div class="w-2 h-2 rounded-full block" :class="getStatus()" />
                </div>
                <div class="flex-1 border-b-2 border-40"></div>
                <div class="flex flex-row">
                    <button
                        class="py-4 px-6 border-b-2 focus:outline-none tab"
                        :class="[activeTab === tab.id ? 'text-grey-black font-bold border-primary': 'text-grey font-semibold border-40']"
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
                    v-show="tab.id === activeTab"
                    :label="tab.name"
                    :key="'related-tabs-fields' + index"
                >
                    <div>
                        <div class="relative my-4 flex justify-end" v-if="activeTab === 0">
                                <button type="button" @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                                    <span class="flex gap-2 items-center">
                                        <span>{{ __('Menu') }}</span>
                                        <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                                <div v-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                                <span
                                    @click="editMachine"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer"
                                >
                                    {{ __('Edit') }}
                                </span>
                                <span
                                    @click="duplicateMachine"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer">
                                    {{ __('Duplicate') }}
                                </span>
                                <span
                                    @click="openDeleteModal"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer">
                                    {{ __('Delete') }}
                                </span>
                                </div>
                        </div>

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
        <portal
            to="modals"
            transition="fade-transition"
            v-if="deleteModalOpen || duplicateModalOpen"
        >
            <delete-resource-modal
                v-if="deleteModalOpen"
                @confirm="confirmDelete"
                @close="closeDeleteModal"
                mode="delete"
            >
                <div slot-scope="{ uppercaseMode, mode }" class="p-8">
                    <heading :level="2" class="mb-6">{{
                            __(uppercaseMode + ' Resource')
                        }}</heading>
                    <p class="text-80 leading-normal">
                        {{ __('Are you sure you want to ' + mode + ' this resource?') }}
                    </p>
                </div>
            </delete-resource-modal>

            <modal
                v-if="duplicateModalOpen"
                @modal-close="closeDuplicateModal"
           >
                <form @submit.prevent.stop="confirmDuplicateModal" class="bg-white rounded-lg shadow-lg overflow-hidden w-action">
                    <div>
                        <heading :level="2" class="border-b border-40 py-8 px-8">Confirm action</heading>
                        <p class="text-80 px-8 my-8"> Are you sure you want to perform this action? </p>
                    </div>
                    <div class="bg-30 px-6 py-3 flex">
                        <div class="flex items-center ml-auto">
                            <button type="button" @click.prevent="closeDuplicateModal" class="btn btn-link dim cursor-pointer text-80 ml-auto mr-6">
                                {{ __('Cancel') }}
                            </button>
                            <button :disabled="working" type="submit" class="btn btn-default btn-primary">
                                <loader v-if="working" width="30"></loader>
                                <span v-else>{{ __('Confirm') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </modal>

        </portal>
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
            pans: null,
            dropdownOpen: false,
            deleteModalOpen: false,
            duplicateModalOpen: false,
            working: false
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
            if(field.pan !== "Profile") {
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
            }
        })

        this.tabs = tabs;
        if(this.$route.query.measurement){
            this.handleTabClick(tabs[Object.keys(tabs)[2]]);
        } else {
            this.handleTabClick(tabs[Object.keys(tabs)[0]]);
        }
    },
    watch:{
        $route(newValue){
            if(newValue.query.tab) {
                this.handleTabClick(this.tabs[Object.keys(this.tabs)[newValue.query.tab]]);
            }
        }
    },
    methods: {
        /**
         * Handle the actionExecuted event and pass it up the chain.
         */
        actionExecuted() {
            this.$emit("actionExecuted");
        },

        handleTabClick(tab, event) {
            if(this.$route.query.tab){
                this.$router.push(`${this.$route.path}?tab=${tab.id}`)
            }

            tab.init = true;
            this.activeTab = tab.id;
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
        },

        editMachine() {
            this.$router.push(`/resources/machines/${this.resourceId}/edit`);
        },

        duplicateMachine() {
            this.duplicateModalOpen = true;
        },

        async confirmDuplicateModal() {
            this.working = true;
            const { data } = await Nova.request().get(`/akka/panels/machines/${this.resourceId}/duplicate`);
            this.working = false;
            this.$router.push(`/resources/machines/${data.machine.id}/edit`);

        },

        closeDuplicateModal() {
            this.duplicateModalOpen = false;
        },

        openDeleteModal() {
            this.deleteModalOpen = true
        },

        async confirmDelete() {
            await Nova.request().delete(`/nova-api/machines?`,
                {
                    params: {
                        resources: [this.resourceId]
                    }
                }
            )
            this.closeDeleteModal();
            this.$router.push('/resources/machines');
        },

        closeDeleteModal() {
            this.deleteModalOpen = false
        },

        getStatus() {
            // const status = this.panel.fields.find(field => field.indexName === "state");
            const status = {
                value: "suspended"
            }
            switch(status.value){
                case 'suspended':
                    return 'bg-red-600';
                case 'not_operative':
                    return 'bg-yellow-500';
                case 'active':
                default:
                    return 'bg-green-500';

            }
            return 'bg-green-500';
        }
    }
}
</script>

<style>
.title  {
    padding-top: .125rem;
    padding-bottom: .125rem;
}
</style>
