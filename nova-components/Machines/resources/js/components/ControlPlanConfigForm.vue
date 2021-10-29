<template>
    <div class="control-plan-config">
        <form
            v-if="panels"
            @submit="submitViaCreateResource"
            @change="onUpdateFormStatus"
            autocomplete="off"
            ref="form"
        >
            <div class="flex justify-end p-4 w-full">
                <button type="submit" class="btn btn-default btn-primary">{{ __('Create Control Plan') }}</button>
            </div>
            <form-panel
                class="mb-8"
                v-for="panel in panelsWithFields"
                @field-changed="onUpdateFormStatus"
                :shown-via-new-relation-modal="false"
                :panel="panel"
                :name="panel.name"
                :key="panel.name"
                resource-name="control-plan-configs"
                :fields="panel.fields"
                mode="form"
                :validation-errors="validationErrors"
                via-resource="machines"
                :via-resource-id="resourceId"
                :via-relationship="viaRelationship"
            />
        </form>
        <component-config :resource-id="resourceId" ref="compos" />
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
        resourceId: {
            type: String,
        },
    },

    data: () => ({
        mode: 'form',
        viaRelationship:"controlPlanConfig",
        submittedViaCreateResource: false,
        viaResource:"machines",
        viaResourceId: null,
        shouldOverrideMeta: true,
        relationResponse: null,
        loading: true,
        fields: [],
        panels: [],
        submitted: false
    }),

    async created() {
        if (Nova.missingResource('control-plan-configs'))
            return this.$router.push({ name: '404' })

        // If this create is via a relation index, then let's grab the field
        // and use the label for that as the one we use for the title and buttons
        const { data } = await Nova.request().get(
            '/nova-api/machines/field/controlPlanConfig',
            {
                params: {
                    resourceName: 'control-plan-configs',
                    viaResource: 'machines',
                    viaResourceId: this.resourceId,
                    viaRelationship: 'controlPlanConfig'
                },
            }
        )
        this.relationResponse = data

        if (this.alreadyFilled) {
            Nova.error(this.__('The HasOne relationship has already been filled.'))

            this.$router.push({
                name: 'detail',
                params: {
                    resourceId: this.resourceId,
                    resourceName: this.resourceName,
                },
            })
        }

        await this.getFields()
    },

    methods: {
        /**
         * Get the available fields for the resource.
         */
        async getFields() {
            this.panels = []
            this.fields = []

            const {
                data: { panels, fields },
            } = await Nova.request().get(
                `/nova-api/control-plan-configs/creation-fields`,
                {
                    params: {
                        editing: true,
                        editMode: 'create',
                        viaResource: this.resourceName,
                        viaResourceId: this.resourceId,
                        viaRelationship: 'controlPlanConfig'
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
                        this.__('The configuration was created!')
                    )
                    this.$emit('createdConfig');
                } catch (error) {
                    console.log("erri", error)
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
                `/nova-api/control-plan-configs`,
                this.createResourceFormData(),
                {
                    params: {
                        editing: true,
                        editMode: 'create',
                    },
                }
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

                formData.append('viaResource', 'machines')
                formData.append('viaResourceId', this.resourceId)
                formData.append('viaRelationship', 'controlPlanConfig')
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
