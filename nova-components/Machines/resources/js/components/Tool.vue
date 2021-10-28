<template>
  <div>
      <div class="relationship-tabs-panel card">

          <div class="flex flex-row">
              <button
                  class="py-5 px-8 border-b-2 focus:outline-none tab self-center"
                  :class="[activeTab === tab.name ? 'text-grey-black font-bold border-primary': 'text-grey font-semibold border-40']"
                  v-for="(tab, key) in tabs"
                  :key="key"
                  @click="handleTabClick(tab, $event)"
              >{{ tab.name }}
              </button>

              <div class="border-b-2 border-40 flex">
                  <div class="flex items-center">
                      <create-relation-button
                          @click="openRelationModal"
                          class="ml-1"
                          :dusk="`component-inline-create`"
                      />
                  </div>
              </div>

              <div class="flex-1 border-b-2 border-40"></div>
          </div>
      </div>
      <div
          v-for="(tab, index) in tabs"
          v-if="tab.init"
          v-show="tab.name === activeTab"
          :label="tab.name"
          :key="'related-tabs-fields' + index"
      >
          <div>
              <div v-for="(field, index) in tab.fields" class="border-b-2 my-3 px-3">
                  <h6>{{ index }}</h6>
                  <div>{{ __(field) }}</div>
              </div>
          </div>
      </div>
      <portal to="modals" transition="fade-transition">
          <modal
              v-if="relationModalOpen"
              dusk="new-relation-modal"
              tabindex="-1"
              role="dialog"
              @modal-close="closeRelationModal"
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
                      @cancelled-create="closeRelationModal"
                      resource-name="components"
                      resource-id=""
                      via-resource="machines"
                      :via-resource-id="resourceId"
                      via-relationship="components"
                  />
              </div>
          </modal>
      </portal>
  </div>
</template>

<script>
import Title from "./Title";
import Create from '../../../../../nova/resources/js/views/Create'

export default {
    props: ['resourceName', 'resourceId', 'panel'],
    components: {
      Title,
        Create
    },
    data () {
        return {
            tabs: null,
            activeTab: "",
            relationModalOpen: false,
        }
    },
    mounted() {
        this.fetchData();
        console.log("panel", this.data);
    },
    methods: {
        async fetchData () {
            let tabs = {}
            const { data } = await Nova.request().get(`/nova-vendor/machines/components/${this.resourceId}`);
            data.components.forEach(component => {
                if (!tabs.hasOwnProperty(component.name)) {
                    tabs[component.name] = {
                        name: component.name,
                        init: false,
                        fields: {...component}
                    }
                }

                tabs[component.name].fields = {
                    ...tabs[component.name].fields,
                    ...component
                };
            })

            this.tabs = tabs
            this.handleTabClick(tabs[Object.keys(tabs)[0]]);
        },
        handleTabClick(tab, event) {
            tab.init = true
            this.activeTab = tab.name
        },
        openRelationModal() {
            this.relationModalOpen = true
        },

        closeRelationModal() {
            this.relationModalOpen = false
        },

        handleSetResource() {
            this.closeRelationModal();
            this.fetchData();
        },

    }
}
</script>
