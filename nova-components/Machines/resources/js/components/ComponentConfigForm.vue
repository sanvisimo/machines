<template>
    <div class="components-forms">
        <form
            v-if="panels"
            @submit.prevent="submitViaCreateResource"
            autocomplete="off"
            ref="form"
        >
            <button type="submit" ref="button" v-show="false">submit</button>
            <form-panel
                class="mb-8"
                v-for="panel in panelsWithFields"
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
                :via-relationship="viaRelationship"
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

        update: {
            type: Boolean
        }
    },

    data: () => ({
        mode: 'form',
        viaRelationship:"component",
        viaResource:"components",
        viaResourceId: null,
        controlPlanConfig: null,
        shouldOverrideMeta: true,
        relationResponse: null,
        loading: true,
        fields: [],
        panels: [],
        componentConfigId: null,
    }),

    async mounted() {
        if (Nova.missingResource('measurement-configs'))
            return this.$router.push({ name: '404' })

        await this.getFields()
    },

    methods: {
        async submitForm(id){
            this.controlPlanConfig = id;
            this.$refs.button.click();
        },
        /**
         * Get the available fields for the resource.
         */
        async getFields() {
            this.panels = []
            this.fields = []

            let url = `/nova-api/measurement-configs/creation-fields`;
            if(this.update){
                const { data } = await Nova.request().get(`/nova-vendor/machines/components-config/${this.componentId}/${this.position}`);
                this.componentConfigId = data.id
                console.log('data', data)
                url = `/nova-api/measurement-configs/${data.id}/update-fields`;
            }

            const {
                data: { panels, fields },
            } = await Nova.request().get(
                url,
                {
                    params: {
                        editing: true,
                        editMode: this.update ? 'update' : 'create',
                        viaResource: this.update ? '' : 'components',
                        viaResourceId: this.update ? '' : this.componentId,
                        viaRelationship: this.update ? '' : 'component'
                    },
                }
            )

            this.panels = panels;
            this.fields = _.map(fields, field => {
                if(field.attribute === 'image'){
                    return {
                        ...field,
                        attribute: 'image' + this.position,
                        sortableUriKey: 'image' + this.position,
                        validationKey: 'image' + this.position,
                    }
                }
                return field;
            })
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
            let url = `/nova-vendor/machines/components-config`;
            if(this.update) {
                url = `/nova-vendor/machines/components-config/${this.componentConfigId}`;
            }

            return Nova.request().post(
                url,
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

                formData.set('image', formData.get('image'+this.position));
                formData.delete('image'+this.position);
                formData.append('control_plan_config_id', this.controlPlanConfig);
                formData.append('component_id', this.componentId);
                formData.append('position', this.position);
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


