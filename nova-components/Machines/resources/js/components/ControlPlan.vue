<template>
    <loading-view :loading="loading">
<!--        <div class="relative my-4">-->
<!--            <button type="button" @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">-->
<!--                <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">-->
<!--                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />-->
<!--                </svg>-->
<!--            </button>-->

<!--            <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>-->

<!--            <div v-show="dropdownOpen" class="absolute left-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">-->
<!--                <span-->
<!--                    @click="editConfig"-->
<!--                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer"-->
<!--                >-->
<!--                    {{ __('Edit') }}-->
<!--                </span>-->
<!--                <span class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer">-->
<!--                    {{ __('Delete') }}-->
<!--                </span>-->
<!--            </div>-->
<!--        </div>-->

        <div v-if="!isConfigPlan">
           <control-plan-form :machine="resourceId" @edit="editConfig"/>
        </div>
        <div v-else>
            <card class="mb-6 py-3 px-6 flex justify-center items-center border border-dashed" v-if="!showConfig">
                <button @click="createConfigPlan" class="btn btn-default btn-primary">
                    {{ __('Configure Control Plan') }}
                </button>
            </card>
            <div v-if="showConfig">
                <config-control-plan
                    :resource-id="resourceId"
                    resource-name="machines"
                    @createdConfig="handleCreated"
                    :update="isUpdate"
                    :id="configPlan.id"
                    @cancel="closeEdit"
                />
            </div>
        </div>
    </loading-view>
</template>

<script>
import {
    Errors,
    InteractsWithResourceInformation,
} from 'laravel-nova'
import HandlesFormRequest from '../../../../../nova/resources/js/mixins/HandlesFormRequest'
import HandlesUploads from '../../../../../nova/resources/js/mixins/HandlesUploads'
import ControlPlanForm from "./ControlPlanForm";

export default {
    components: {ControlPlanForm},
    mixins: [
        InteractsWithResourceInformation,
        HandlesFormRequest,
        HandlesUploads,
    ],

    metaInfo() {
        if (this.shouldOverrideMeta && this.resourceInformation) {
            return {
                title: this.__('Create :resource', {
                    resource: 'Control Plan',
                }),
            }
        }
    },

    props: {
        updateFormStatus: {
            type: Function,
            default: () => {},
        },
        resourceName: {
            type: String,
        },
        resourceId: {
            type: String,
        },
    },

    data: () => ({
        loading: true,
        configPlan: null,
        isConfigPlan: true,
        showConfig: false,
        isUpdate: false,
        dropdownOpen: false,
        viaRelationship:"controlPlansConfig",
        viaResource:"machines",
        viaResourceId: null,
        shouldOverrideMeta: true,
        relationResponse: null,
        submittedViaCreateResourceAndAddAnother: false,
        submittedViaCreateResource: false,
        fields: [],
        panels: [],
    }),

    async created() {
        if (Nova.missingResource('control-plan-configs'))
            return this.$router.push({ name: '404' })
        await this.getControlPlanConfig();
    },

    methods: {
        /*
        * Check if control plan configuration exist
         */
        async getControlPlanConfig() {
            const { data } = await Nova.request().get(`/nova-vendor/machines/control-plan-configs/${this.resourceId}`);
            this.configPlan = data.controlPlan;
            this.isConfigPlan = !data.controlPlan;
            this.showConfig = !!data.controlPlan;
            this.loading = false;
        },

        createConfigPlan() {
            this.showConfig = true;
            this.isConfigPlan = true;
        },

        handleCreated() {
            this.showConfig = false;
            this.isConfigPlan = false;
        },

        editConfig() {
            this.dropdownOpen = false;
            this.isUpdate = true;
            this.isConfigPlan = true;
            this.showConfig = true;
        },

        closeEdit() {
            this.isUpdate = false;
            this.isConfigPlan = false;
        }
    },
}
</script>
