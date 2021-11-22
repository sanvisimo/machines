<template>
  <div class="my-3">

      <div class="flex justify-between my-2">
          <h2>{{ name }}</h2>
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
          <div class="relative my-4 flex justify-end">
              <button type="button" @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                                    <span class="flex gap-2 items-center">
                                        <span>{{ __('Menu') }}</span>
                                        <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
              </button>

              <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

              <div v-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-md shadow-xl z-20">
                                <span
                                    @click="openEditModal"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer"
                                >
                                    {{ __('Edit') }}
                                </span>
                  <span
                      @click="openDeleteModal"
                      class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer">
                                    {{ __('Delete') }}
                                </span>
              </div>
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
                                  <a :href="`/storage/${attachment.file_path}`" target="_blank">{{ attachment.name }}</a>
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
          <modal
              v-if="editModalOpen"
              dusk="edit-relation-modal"
              tabindex="-1"
              role="dialog"
              @modal-close="closeEditModal"
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
              <Update
                  mode="modal"
                  @refresh="handleUpdate"
                  @cancelled="closeEditModal"
                  resource-name="components"
                  :resource-id="component.id"
                  via-resource="machines"
                  :via-resource-id="component.machine_id"
                  via-relationship="components"
              />
            </div>
          </modal>
          <delete-resource-modal
              v-if="deleteModalOpen"
              @confirm="confirmDelete"
              @close="closeDeleteModal"
              mode="delete"
          >
              <div slot-scope="{ uppercaseMode, mode }" class="p-8">
                  <heading :level="2" class="mb-6">{{
                          __(uppercaseMode + ' Resource')
                      }}</heading>
                  <p class="text-80 leading-normal">
                      {{ __('Are you sure you want to ' + mode + ' this resource?') }}
                  </p>
              </div>
          </delete-resource-modal>

      </portal>
  </div>
</template>

<script>
import ComponentDetailField from "./ComponentDetailField";
import Create from '../../../../../nova/resources/js/views/Create'
import Update from './Update'
import HandlesFormRequest from '../../../../../nova/resources/js/mixins/HandlesFormRequest'
import HandlesUploads from '../../../../../nova/resources/js/mixins/HandlesUploads'

export default {
    name: "ComponentDetail",
    components: { ComponentDetailField, Create, Update },
    props: ['component', 'attrs'],
    data() {
      return {
          active: false,
          heading: {},
          name: "",
          info: {},
          attachments: {},
          resource: {},
          panel: {},
          documentModalOpen: false,
          editModalOpen: false,
          deleteModalOpen: false,
          dropdownOpen: false,
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
                name,
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

            this.name = name;
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

        openEditModal() {
            this.editModalOpen = true;
            this.dropdownOpen = false;
        },

        closeEditModal() {
          this.editModalOpen = false;
            this.dropdownOpen = false;
        },

        handleUpdate(resource) {
          const {
            name,
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
          } = resource;

          this.name = name;

          this.heading = {
            constructor,
            "category > subcategory": `${category} > ${subcategory}`
          }

          this.info = info;
            this.closeEditModal()
        },

        handleSetResource() {
            this.getInfo();
            this.fetchAttachments();
            this.fetchArticles();
            this.closeDocumentModal();
        },

        openDeleteModal() {
            this.deleteModalOpen = true;
            this.dropdownOpen = false;
        },

        async confirmDelete() {
            await Nova.request().delete(`/nova-api/components?`,
                {
                    params: {
                        resources: [this.component.id]
                    }
                }
            )
            this.closeDeleteModal();
            this.$emit('deleted');
        },

        closeDeleteModal() {
            this.deleteModalOpen = false;
            this.dropdownOpen = false;
        },
    }
}
</script>

<style scoped>

</style>
