<template>
  <div class="my-3">

      <div class="flex justify-between my-2">
          <h2>{{ component.name }}</h2>
          <div>
              <router-link
                  :to="{
                        name: 'create',
                        params: {
                            resourceName: 'maintenances',
                        },
                        query: {
                            viaRelationship: 'maintenances',
                            viaResource: 'components',
                            viaResourceId: component.id
                        }
                    }"
                  class="btn btn-default btn-icon bg-primary text-white"
                  :title="__('Create')"
              >
                 {{ __('Extraordinary Manutention' ) }}
              </router-link>
          </div>
          <div>
              &nbsp;
          </div>
      </div>

      <card class="mb-6 py-3 px-6">
          <component-detail-field v-for="(field, index) in heading" :key="`component-${component.id}-${index}`" :label="index" :value="field" />
      </card>

      <div class="accordion">
          <div class="accordion__header">
              <div class="accordion__link py-4 px-4 block flex justify-center cursor-pointer" @click.prevent="active = !active">
                  <div class="bg-blue-dark hover:bg-blue-darker no-underline border p-2">
                      <strong v-if="!active">{{ __('Show Info') }}</strong>
                      <strong v-if="active">{{ __('Close Info') }}</strong>
                  </div>
              </div>
          </div>
          <div class="accordion__content p-4" v-show="active">
              <card class="mb-6 py-3 px-6">
                  <div class="grid grid-cols-2 gap-4">
                      <component-detail-field
                          v-for="(field, index) in info"
                          :key="'accordion-' + index"
                          :label="index"
                          :value="field"
                      />
                  </div>
              </card>

              <card class="mb-6 py-3 px-6">
                  <h3>{{ __('Report') }} </h3>
              </card>

              <card class="mb-6 py-3 px-6 flex gap-40">
                  <div class="flex items-start">
                      <h3>{{__('Documents') }}</h3>
                      <create-relation-button
                          v-if="attrs.resource.authorizedToCreate"
                          @click="openDocumentModal"
                          class="ml-1"
                          :dusk="`attachments-inline-create`"
                      />
                  </div>
                  <div class="w-full">
                      <div v-for="(group, index) in attachments" :key="`attachment-C${component.id}-${index}`" class="border-b border-40 flex justify-between pb-4 mb-4">
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

              <component
                  is="relationship-panel"
                  name="Articoli"
                  :panel="panel"
                  :resourceId="component.id"
                  resourceName="components"
                  :resource="resource"
              />
          </div>
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
                      via-resource="components"
                      :via-resource-id="component.id"
                      via-relationship="attachments"
                  />
              </div>
          </modal>
      </portal>
  </div>
</template>

<script>
import ComponentDetailField from "./ComponentDetailField";
import Create from '../../../../../nova/resources/js/views/Create'

export default {
    name: "ComponentDetail",
    components: { ComponentDetailField, Create },
    props: ['component', 'attrs'],
    data() {
      return {
          active: false,
          heading: {},
          info: {},
          attachments: {},
          resource: {},
          panel: {},
          documentModalOpen: false
      }
    },
    mounted() {
        this.getInfo();
        this.fetchAttachments();
        this.fetchArticles();
    },
    methods: {
        getInfo() {
            const {
                constructor,
                category,
                subcategory,
                component_category_id,
                id,
                machine_id,
                component_sub_category_id,
                created_at,
                updated_at,
                ...info
            } = this.component
            this.heading = {
                constructor,
                "category > subcategory": `${category} > ${subcategory}`
            }

            this.info = info;
        },

        async fetchArticles() {
            const { data } = await Nova.request().get(`/nova-api/components/${this.component.id}`);
            this.resource = data.resource;
            this.panel = {
                component: "relationship-panel",
                name: this.__("Articles"),
                prefixComponent:true,
                fields: [data.resource.fields[data.resource.fields.length - 1]]
            }
        },

        async fetchAttachments () {
            const { data } = await Nova.request().get(`/nova-vendor/machines/components/${this.component.id}/attachments`);
            this.attachments = _.groupBy(data.attachments, 'type')
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
        openDocumentModal() {
            this.documentModalOpen = true
        },

        closeDocumentModal() {
            this.documentModalOpen = false
        },

        handleSetResource() {
            this.getInfo();
            this.fetchAttachments();
            this.fetchArticles();
            this.closeDocumentModal();
        },
    }
}
</script>

<style scoped>

</style>
