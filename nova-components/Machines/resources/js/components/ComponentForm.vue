<template>
    <div class="">
        <form
            v-if="panels"
            @submit.prevent="submitViaCreateResource"
            @change="onUpdateFormStatus"
            autocomplete="off"
            ref="form"
        >
            <button type="submit" ref="button" v-show="false">submit</button>
            <form-panel
                class="mb-8"
                v-for="panel in panelsWithFields"
                @field-changed="onUpdateFormStatus"
                :shown-via-new-relation-modal="false"
                :panel="panel"
                :name="panel.name"
                :key="panel.name"
                resource-name="measurement-configs"
                :fields="panel.fields"
                mode="form"
                :validation-errors="validationErrors"
                via-resource="components"
                :via-resource-id="componentId"
                via-relationship=""
            />
        </form>
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

        componentId: {
            type: Number,
        },

        position: {
            type: String
        },

        controlPlan: {
            type: Object
        }
    },

    data: () => ({
        mode: 'form',
        measurement: {},
        controlPlanId: null,
        shouldOverrideMeta: true,
        relationResponse: null,
        loading: true,
        fields: [],
        panels: [],
    }),

    async created() {
        if (Nova.missingResource('measurements'))
            return this.$router.push({ name: '404' })

        const { data } = await Nova.request().get(`/nova-vendor/machines/measurements/${this.controlPlan.id}/${this.position}`)
        this.measurement = data.measurement;

        await this.getFields()
    },

    methods: {
        async submitForm(id){
            this.controlPlanId = id;
            this.$refs.button.click();
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
                `/nova-api/measurements/${this.measurement.id}/update-fields`,
                {
                    params: {
                        editing: true,
                        editMode: 'update',
                        viaResource: 'components',
                        position: this.position,
                        viaResourceId: this.componentId,
                        viaRelationship: ''
                    },
                }
            )

            this.panels = panels
            this.fields = fields
            this.loading = false
        },

        async submitViaCreateResource(e) {
            e.preventDefault()
            await this.createRequest()
        },

        /**
         * Send a create request for this resource
         */
        async createRequest() {
            return Nova.request().post(
                `/nova-vendor/machines/components/${this.measurement.id}`,
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


