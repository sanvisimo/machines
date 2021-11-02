<template>
    <div class="control-plan">
        <form
            v-if="panels"
            @submit="submitViaCreateResource"
            @change="onUpdateFormStatus"
            autocomplete="off"
            ref="form"
        >
            <div class="flex justify-end p-4 w-full gap-4">
                <button type="submit" class="btn btn-default btn-primary">{{ __('Create Control Plan') }}</button>
                <span
                    @click="$emit('edit')"
                    class="btn btn-default cursor-pointer btn-white"
                >
                    {{ __('Edit') }}
                </span>
            </div>


            <form-panel
                v-for="panel in panelsWithFields"
                @update-last-retrieved-at-timestamp="updateLastRetrievedAtTimestamp"
                @field-changed="onUpdateFormStatus"
                @file-upload-started="handleFileUploadStarted"
                @file-upload-finished="handleFileUploadFinished"
                :panel="panel"
                :name="panel.name"
                :key="panel.name"
                :resource-id="controlPlan.id"
                resource-name="control-plans"
                :fields="panel.fields"
                mode="form"
                class="mb-8"
                :validation-errors="validationErrors"
                via-resource="machines"
                :via-resource-id="machine"
                via-relationship="controlPlans"
            />

        </form>
        <component-config :resource-id="machine" ref="compos" :config="false" />
        <div class="flex justify-end p-4 w-full">
            <button type="button" class="btn btn-default btn-primary" @click="submitViaCreateResource">{{ __('Create Control Plan') }}</button>
        </div>
    </div>
</template>

<script>
import {
    Errors,
    InteractsWithResourceInformation,
} from 'laravel-nova'
import HandlesFormRequest from '../../../../../nova/resources/js/mixins/HandlesFormRequest'
import HandlesUploads from '../../../../../nova/resources/js/mixins/HandlesUploads'

export default {
    mixins: [
        InteractsWithResourceInformation,
        HandlesFormRequest,
        HandlesUploads,
    ],

    props: {
        updateFormStatus: {
            type: Function,
            default: () => {},
        },
        resourceName: {
            type: String,
        },
        machine: {
            type: String,
        },
    },

    data: () => ({
        mode: 'form',
        submittedViaCreateResource: false,
        shouldOverrideMeta: true,
        controlPlan: null,
        loading: true,
        fields: [],
        panels: [],
        submitted: false
    }),

    async created() {
        if (Nova.missingResource('control-plans'))
            return this.$router.push({ name: '404' })

        // If this create is via a relation index, then let's grab the field
        // and use the label for that as the one we use for the title and buttons
        const { data } = await Nova.request().get(`/nova-vendor/machines/control-plans/${this.machine}`)
        this.controlPlan = data.controlPlan;

        await this.getFields()
    },

    methods: {
        /**
         * Update the last retrieved at timestamp to the current UNIX timestamp.
         */
        updateLastRetrievedAtTimestamp() {
            this.lastRetrievedAt = Math.floor(new Date().getTime() / 1000)
        },

        /**
         * Get the available fields for the resource.
         */
        async getFields() {
            this.panels = []
            this.fields = []

            const {
                data: { panels, fields },
            } = await Nova.request().get(
                `/nova-api/control-plans/${this.controlPlan.id}/update-fields`,
                {
                    params: {
                        editing: true,
                        editMode: 'update',
                        viaResource: 'machines',
                        viaResourceId:this.machine,
                        viaRelationship: 'controlPlans'
                    },
                }
            )

            this.panels = panels
            this.fields = fields
            this.loading = false
        },

        async submitViaCreateResource(e) {
            e.preventDefault()
            // this.submittedViaCreateResource = false
             await this.createResource()
        },

        /**
         * Create a new resource instance using the provided data.
         */
        async createResource() {
            this.isWorking = true

            if (this.$refs.form.reportValidity()) {
                try {
                    const {
                        data: { redirect, id },
                    } = await this.createRequest()

                    await this.$refs.compos.submitForms(id);

                    this.canLeave = true

                    Nova.success(
                        this.__('The Measurement was created!')
                    )
                    this.$router.go(`${this.$route.path}?tab=0`);
                } catch (error) {
                    window.scrollTo(0, 0)

                    this.submittedViaCreateAndAddAnother = false
                    this.submittedViaCreateResource = true
                    this.isWorking = false

                    if (this.resourceInformation.preventFormAbandonment) {
                        this.canLeave = false
                    }

                    this.handleOnCreateResponseError(error)
                }
            }

            this.submittedViaCreateAndAddAnother = false
            this.submittedViaCreateResource = true
            this.isWorking = false
        },

        /**
         * Send a create request for this resource
         */
        async createRequest() {
            return Nova.request().post(
                `/nova-vendor/machines/control-plans/${this.controlPlan.id}`,
                this.createResourceFormData(),
            )
        },

        /**
         * Create the form data for creating the resource.
         */
        createResourceFormData() {
            return _.tap(new FormData(), formData => {
                _.each(this.fields, field => {
                    field.fill(formData)
                })
            })
        },

        /**
         * Prevent accidental abandonment only if form was changed.
         */
        onUpdateFormStatus() {
            if (this.resourceInformation.preventFormAbandonment) {
                this.updateFormStatus()
            }
        },
    },

    computed: {
        panelsWithFields() {
            return _.map(this.panels, panel => {
                return {
                    ...panel,
                    name: this.__('Control Plan'),
                    fields: _.filter(this.fields, field => field.panel == panel.name),
                }
            })
        },

        alreadyFilled() {
            return this.relationResponse && this.relationResponse.alreadyFilled
        },
    },
}
</script>
