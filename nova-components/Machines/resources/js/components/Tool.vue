<template>
    <div>
        <div class="flex flex-row">
            <button
                class="py-5 px-8 border-b-4 focus:outline-none tab self-center"
                :class="[activeTab === tab.name ? 'text-grey-black font-bold border-primary-30%': 'text-grey font-semibold border-40']"
                v-for="(tab, key) in tabs"
                :key="key"
                @click="handleTabClick(tab, $event)"
            >
                {{ tab.fields.category }}
            </button>

            <div class="border-b-4 border-40 flex py-5 px-8">
                <create-relation-button
                  @click="openRelationModal"
                  class="ml-1"
                  :dusk="`component-inline-create`"
                />
            </div>

            <div class="flex-1 border-b-4 border-40"></div>
      </div>

      <div
          v-for="(tab, index) in tabs"
          v-if="tab.init"
          v-show="tab.name === activeTab"
          :label="tab.name"
          :key="'related-tabs-fields' + index"
      >
          <component-detail :component="tab.fields" />
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
import ComponentDetail from "./ComponentDetail";

export default {
    props: ['resourceName', 'resourceId', 'panel'],
    components: {
        ComponentDetail,
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
    },
    methods: {
        isActive(id){
            return this.$route.query.component && this.$route.query.component == id
        },

        async fetchData () {
            let tabs = {}
            const { data } = await Nova.request().get(`/nova-vendor/machines/components/${this.resourceId}`);
            data.components.forEach(component => {
                if (!tabs.hasOwnProperty(component.name)) {
                    tabs[component.name] = {
                        id: component.id,
                        name: component.name,
                        init: this.isActive(component.id),
                        fields: {...component}
                    }
                }

                if(this.isActive(component.id)) {
                    this.activeTab = component.name
                }

                tabs[component.name].fields = {
                    ...tabs[component.name].fields,
                    ...component
                };
            })

            this.tabs = tabs
            if(!this.activeTab) this.handleTabClick(tabs[Object.keys(tabs)[0]]);
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
