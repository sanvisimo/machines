<template>
  <div>
    <card>
      <table class="table w-full table-default">
        <thead>
          <tr>
            <th v-for="(column, index) in columns" :key="index">
              <span>{{ __(column) }}</span>
            </th>
          </tr>
        </thead>
        <tbody v-for="tab in tabs" :key="tab.index">
          <tr>
            <td colspan="12" class="text-center">
              <h5>{{ tab.name }}</h5>
            </td>
          </tr>
          <component-config-row
              v-if="config"
              v-for="vibration in tab.vibrations"
              :component-id="tab.id"
              :name="`C${tab.index + 1} - B${vibration}`"
              :key="`vibration-C${tab.index}-B${vibration}`"
              :position="`C${tab.index}-B${vibration}`"
              :update="update"
              @edit="updateComponent"
              @upload="uploadImage"
          />
          <component-config-row
              v-if="config"
              v-for="articles in tab.articles"
              :name="`C${tab.index + 1} - P${articles}`"
              :component-id="tab.id"
              :key="`vibration-C${tab.index}-P${articles}`"
              :position="`C${tab.index}-P${articles}`"
              :update="update"
              @edit="updateComponent"
              @upload="uploadImage"
          />
          <component-row
              v-if="!config"
            v-for="vibration in tab.vibrations"
            :key="`C${tab.index}-B${vibration}`"
            :name="`C${tab.index + 1} - B${vibration}`"
            :position="`C${tab.index}-B${vibration}`"
            :component-id="tab.id"
            :ref="`vibration-C${tab.index}-B${vibration}`"
            :control-plan="controlPlan"
            @edit="updateComponent"
          />

          <component-row
              v-if="!config"
            v-for="article in tab.articles"
            :key="`C${tab.index}-P${article}`"
            :name="`C${tab.index + 1} - P${article}`"
            :position="`C${tab.index}-P${article}`"
            :component-id="tab.id"
            :ref="`vibration-C${tab.index}-P${article}`"
            :control-plan="controlPlan"
            @edit="updateComponent"
          />

        </tbody>
      </table>
    </card>
  </div>
</template>

<script>
import Title from "./Title";
import Create from "../../../../../nova/resources/js/views/Create";
import ComponentConfigRow from "./ComponentConfigRow";

export default {
  props: [
    "resourceName",
    "resourceId",
    "panel",
    "config",
    "controlPlan",
    "update",
  ],
  components: {
    Title,
    Create,
      ComponentConfigRow
  },
  data() {
    return {
      tabs: null,
      activeTab: "",
      components: {},
      updateColumns: [
        "Position",
        "Anomaly",
        "Lubricant levels",
        "Lubricant appearence",
        "Leakage",
        "Temperature",
        "Pressure",
        "RPM",
        "HDM",
        "HDC",
        "H",
        "V",
        "A",
        "Notes",
      ],
        configColumns: [
            "Position",
            "Lubricant levels",
            "Lubricant appearence",
            "Leakage",
            "Temperature",
            "Pressure",
            "RPM",
            "SPM",
            "SISM",
            "Image",
        ],
    };
  },
    computed: {
      columns() {
          return this.config ? this.configColumns : this.updateColumns;s
      }
    },
  mounted() {
    this.fetchData();
  },
  methods: {
    async submitForms(id) {
      for (let tab in this.tabs) {
        for (let i = 0; i < this.tabs[tab].vibrations; i++) {
          const key = `vibration-C${this.tabs[tab].index}-B${i + 1}`;
          await this.$refs[key][0].submitForm(id);
        }
        for (let i = 0; i < this.tabs[tab].articles; i++) {
          const key = `position-C${this.tabs[tab].index}-P${i + 1}`;
          await this.$refs[key][0].submitForm(id);
        }
      }
      // this.$refs.positions.submitForm();
    },
    async fetchData() {
      let tabs = {};
      const { data } = await Nova.request().get(
        `/nova-vendor/machines/components-config/${this.resourceId}`
      );
      data.components.forEach((component, index) => {
        if (!tabs.hasOwnProperty(component.name)) {
          tabs[component.name] = {
            id: component.id,
            name: component.name,
            index,
            init: false,
            vibrations: component.vibrations,
            articles:
              component.temperature + component.pressure + component.payload,
          };
        }

        tabs[component.name].fields = {
          ...tabs[component.name].fields,
          ...component,
        };
      });

      this.tabs = tabs;
      this.handleTabClick(tabs[Object.keys(tabs)[0]]);
    },
    handleTabClick(tab, event) {
      tab.init = true;
      this.activeTab = tab.name;
    },
    updateComponent(component) {
      const comps = {...this.components};
      comps[component.position] = component;
      this.components = comps;
      this.$emit('edit', comps);
    },
    uploadImage(file, position){
      this.$emit('upload', file, position);
    },
  },
};
</script>
