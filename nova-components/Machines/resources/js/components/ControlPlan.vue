<template>
    <loading-view :loading="loading">
        <custom-create-header class="mb-3" resource-name="control-plan-configs" />

        <div v-if="configPlan">
           <control-plan-form :machine="resourceId" />
        </div>
        <div v-else>
            <card class="mb-6 py-3 px-6 flex justify-center items-center border border-dashed" v-if="!showConfig">
                <button @click="createConfigPlan" class="btn btn-default btn-primary">
                    {{ __('Configure Control Plan') }}
                </button>
            </card>
            <div v-if="showConfig">
                <config-control-plan :resource-id="resourceId" resource-name="machines" @createdConfig="handleCreated" />
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
        showConfig: false,

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
            this.loading = false;
        },

        createConfigPlan() {
            this.showConfig = true;
        },

        handleCreated() {
            this.showConfig = false;
            this.configPlan = true;
        }
    },
}
</script>
