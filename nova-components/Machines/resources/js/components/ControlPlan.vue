<template>
    <loading-view :loading="loading">
        <div v-if="!isConfigPlan">
           <control-plan-form :resourceName="resourceName" :machine="resourceId" @edit="editConfig" :update="isUpdate" :canEdit="canEdit" />
        </div>
        <div v-else-if="canEdit">
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
                    :id="configPlan ? configPlan.id : null"
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

    async mounted() {
        if (Nova.missingResource('control-plan-configs'))
            return this.$router.push({ name: '404' })
        if(this.$route.params.resourceName === "control-plans"){
           this.isUpdate = true;
        }
        await this.getControlPlanConfig();
    },

    computed: {
        canEdit() {
            return this.$attrs.resource.authorizedToCreate || this.$attrs.resource.authorizedToUpdate;
        }
    },

    methods: {
        /*
        * Check if control plan configuration exist
         */
        async getControlPlanConfig() {
            if(this.resourceName !== 'control-plans') {
                const {data} = await Nova.request().get(`/nova-vendor/machines/control-plan-configs/${this.resourceId}`);
                this.configPlan = data.controlPlan;
                this.isConfigPlan = !data.controlPlan;
                this.showConfig = !!data.controlPlan;
                this.loading = false;
            } else {
                this.isConfigPlan = false;
                this.showConfig = false;
                this.loading = false;
            }
        },

        createConfigPlan() {
            this.showConfig = true;
        },

        async handleCreated() {
            await this.getControlPlanConfig();
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
