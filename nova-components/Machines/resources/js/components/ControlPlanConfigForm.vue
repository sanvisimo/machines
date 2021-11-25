<template>
    <div class="control-plan-config">
        <form
            v-if="panels"
            @submit="submitViaCreateResource"
            autocomplete="off"
            ref="form"
        >
            <div class="flex justify-end p-4 w-full gap-4">
                <button type="submit" class="btn btn-default btn-primary">
                    {{ update ? __('Update configuration') : __('Configure Control Plan') }}
                </button>
                <span
                    @click="$emit('cancel')"
                    class="btn btn-default cursor-pointer btn-white"
                >
                    {{ __('Cancel') }}
                </span>
            </div>
            <form-panel
                class="mb-8"
                v-for="panel in panelsWithFields"
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
        <component-config :resource-id="resourceId" ref="compos" :config="true" :update="update" />
        <div class="flex justify-end p-4 w-full">
            <button type="button" class="btn btn-default btn-primary" @click="submitViaCreateResource">
                {{ update ? __('Update configuration') : __('Configure Control Plan') }}
            </button>
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
        resourceId: {
            type: String,
        },
        update: {
            type: Boolean
        },
        id: {
            type: Number
        }
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

    async mounted() {
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

        if (this.alreadyFilled && !this.update) {
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

            let url = `/nova-api/control-plan-configs/creation-fields`
            if(this.update){
                url = `/nova-api/control-plan-configs/${this.id}/update-fields`
            }

            const {
                data: { panels, fields },
            } = await Nova.request().get(
                url,
                {
                    params: {
                        editing: true,
                        editMode: this.update ? 'update' : 'create',
                        viaResource:  this.resourceName,
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
            let url = `/nova-api/control-plan-configs`;

            if(this.update) {
                url = `/nova-vendor/machines/control-plans-configs/${this.id}`;
            }

            return Nova.request().post(
                url,
                this.createResourceFormData(),
                {
                    params: {
                        editing: true,
                        editMode: this.update ? 'update' : 'create',
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
