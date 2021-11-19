<template>
        <div class="accordion">
            <div class="accordion__header">
                <div class="accordion__link p-4 block flex justify-center cursor-pointer" @click.prevent="active = !active">
                    <div class="bg-blue-dark hover:bg-blue-darker no-underline border p-2">
                        <strong>{{ __('tutte le informazioni') }}</strong>
                    </div>
                </div>
            </div>
            <div class="accordion__content py-3 card px-6" v-show="active">
                <div class="grid grid-cols-2 gap-4">
                    <component
                        v-for="(field, index) in panel.fields"
                        :key="'accordion-' + index"
                        class="col-span-1"
                        :style="{width: 'auto'}"
                        :is="componentName(field)"
                        :resource-name="resourceName"
                        :resource-id="resourceId"
                        :resource="resource"
                        :field="field"
                        @actionExecuted="actionExecuted"
                    />
                </div>
            </div>
            <div
                class="accordion__content mt-4"
                v-if="resourceName === 'machines'"
                v-show="active"
            >
                <card class="mb-6 py-3 px-6 flex gap-40">
                    <div class="flex items-start">
                        <h3>{{__('Documents') }}</h3>
                        <create-relation-button
                            v-if="resource.authorizedToCreate"
                            @click="openDocumentModal"
                            class="ml-1"
                            :dusk="`attachments-inline-create`"
                        />
                    </div>
                    <div class="w-full">
                        <div v-for="(group, index) in attachments" :key="`attachment-machines-${resourceId}-${index}`" class="border-b border-40 flex justify-between pb-4 mb-4">
                            <h4 class="font-normal text-80">{{ __(index) }}</h4>
                            <div>
                                <div v-for="(attachment, id) in group" :key="`attachment-${attachment.id}`" class="flex items-center justify-end gap-2">
                                    <a :href="`/storage/${attachment.file_path}`" _target="blank">{{ attachment.name }}</a>
                                    <div>
                                        <font-awesome-icon :icon="`fa-solid ${icon(attachment.file_path)}`" /> <span>{{ last(attachment.file_path) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </card>
            </div>
            <portal to="modals" transition="fade-transition">
                <modal
                    v-if="documentModalOpen"
                    dusk="new-relation-modal"
                    tabindex="-1"
                    role="dialog"
                    @modal-close="closeDocumentModal"
                    :classWhitelist="[
                              'flatpickr-current-month',
                              'flatpickr-next-month',
                              'flatpickr-prev-month',
                              'flatpickr-weekday',
                              'flatpickr-weekdays',
                              'flatpickr-calendar',
                              'form-file-input',
                            ]"
                >
                    <div
                        class="bg-40 rounded-lg shadow-lg overflow-hidden p-8"
                        style="width: 1000px"
                    >
                        <Create
                            mode="modal"
                            @refresh="handleSetResource"
                            @cancelled-create="closeDocumentModal"
                            resource-name="attachments"
                            resource-id=""
                            via-resource="machines"
                            :via-resource-id="resourceId"
                            via-relationship="attachments"
                        />
                    </div>
                </modal>
            </portal>
        </div>

</template>

<script>
import BehavesAsPanel from 'laravel-nova/src/mixins/BehavesAsPanel'
import Create from '../../../../../nova/resources/js/views/Create'

export default {
    mixins: [ BehavesAsPanel ],
    components: { Create },
    data() {
        return {
            active: false,
            attachments: [],
            documentModalOpen: false,
        };
    },
    props: ['panel', 'resourceName', 'resourceid', 'resource'],
    mounted() {
        document.getElementsByClassName('accordion')[0].classList.remove('flex-dom')
        document.getElementsByClassName('accordion')[0].classList.remove('flex-wrap')
        document.getElementsByClassName('accordion')[0].classList.remove('flex')
        if(this.resourceName === "machines") {
            this.fetchAttachments();
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
            tab.init = true
            this.activeTab = tab.name
        },

        componentName(field) {
            return field.prefixComponent ? 'detail-' + field.component : field.component
        },

        last(name) {
            return name.slice(-4)
        },

        icon(name) {
            const ext = name.slice(-3);
            switch(ext) {
                case 'jpg':
                    return 'fa-file-image';
                case 'pdf':
                default:
                    return 'fa-file-pdf';
            }

        },

        async fetchAttachments () {
            const { data } = await Nova.request().get(`/nova-vendor/machines/machines/${this.resourceId}/attachments`);
            this.attachments = _.groupBy(data.attachments, 'type')
        },
        openDocumentModal() {
            this.documentModalOpen = true
        },

        closeDocumentModal() {
            this.documentModalOpen = false
        },
        handleSetResource() {
            this.fetchAttachments();
            this.closeDocumentModal();
        },
    }
}
</script>
