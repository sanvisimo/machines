<template>
  <tr>
    <td>
      <div class="text-90 font-normal text-lg flex justify-between items-center">
        <span class="flex-no-shrink">{{ name }}</span>
        <span class="cursor-pointer ml-2" @click="openImage" v-if="imageUrl">
          <font-awesome-icon icon="fa-solid fa-file-image" />
        </span>
      </div>
      <portal to="modals">
        <image-detail
          v-if="imageOpen"
          @close="closeImage"
          :image-url="imageUrl"
        />
      </portal>
    </td>
    <td>
      <div>
        <button-group
          :inputData.sync="field.anomaly"
          @update:inputData="edit"
          :icon="true"
          :disabled="false"
          :options="[
            { value: 1, label: 'fa-thumbs-up' },
            { value: 0, label: 'fa-thumbs-down' },
          ]"
        />
      </div>
    </td>
    <td>
      <div>
        <button-group
          :inputData.sync="field.lubricant_levels"
          :disabled="getFieldByAttribute('lubricant_levels')"
          :icon="false"
          @update:inputData="edit"
          :options="[
            { label: 'L', value: 'low' },
            { label: 'M', value: 'medium' },
            { label: 'H', value: 'high' },
          ]"
        />
      </div>
    </td>
    <td>
      <div>
        <button-group
          :inputData.sync="field.lubricant_appearence"
          :disabled="getFieldByAttribute('lubricant_appearence')"
          :icon="false"
          @update:inputData="edit"
          :options="[
            { label: 'C', value: 'clear' },
            { label: 'T', value: 'turbid' },
            { label: 'D', value: 'dark' },
          ]"
        />
      </div>
    </td>
    <td>
      <div>
        <button-group
          :inputData.sync="field.leakage"
          @update:inputData="edit"
          :disabled="getFieldByAttribute('leakage')"
          :icon="true"
          :options="[
            { value: 1, label: 'fa-thumbs-up' },
            { value: 0, label: 'fa-thumbs-down' },
          ]"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          type="number"
          :inputData.sync="field.temperature"
          :disabled="getFieldByAttribute('temperature')"
          placeholder="°C"
          @update:inputData="edit"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          :inputData.sync="field.pressure"
          :disabled="getFieldByAttribute('pressure')"
          type="number"
          placeholder="Bar"
          @update:inputData="edit"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          :inputData.sync="field.rpm"
          :disabled="getFieldByAttribute('rpm')"
          type="number"
          placeholder="0"
          @update:inputData="edit"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          :inputData.sync="field.vibrations_type_SPM"
          :disabled="getFieldByAttribute('vibrations_type_SPM')"
          type="number"
          placeholder="0"
          @update:inputData="edit"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          :inputData.sync="field.vibrations_type_SPM_1"
          :disabled="getFieldByAttribute('vibrations_type_SPM_2')"
          type="number"
          placeholder="0"
          @update:inputData="edit"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
          :inputData.sync="field.vibrations_type_SISM_1"
          @update:inputData="edit"
          :disabled="getFieldByAttribute('vibrations_type_SISM_1')"
          type="number"
          placeholder="0"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
            :inputData.sync="field.vibrations_type_SISM_2"
            @update:inputData="edit"
            :disabled="getFieldByAttribute('vibrations_type_SISM_2')"
            type="number"
            placeholder="0"
        />
      </div>
    </td>
    <td>
      <div>
        <input-text
            :inputData.sync="field.vibrations_type_SISM_3"
            @update:inputData="edit"
            :disabled="getFieldByAttribute('vibrations_type_SISM_3')"
            type="number"
            placeholder="0"
        />
      </div>
    </td>
    <td>
      <div class="text-lg cursor-pointer" @click="openNote">
        <i class="fa-regular fa-message" />
        <portal to="modals">
          <note-field
            v-if="noteOpen"
            @close="closeNote"
            @update="updateNotes"
            :notes="field.anomaly_notes"
          />
        </portal>
      </div>
    </td>
  </tr>
</template>

<script>
import ButtonGroup from "../form/ButtonGroup.vue";
import InputText from "../form/InputText.vue";
import ImageDetail from "../detail/ImageDetail";
import NoteField from "../form/NoteField";

export default {
  components: {NoteField, ImageDetail, ButtonGroup, InputText },
  props: {
    name: {
      type: String,
    },
    componentId: {
      type: Number,
    },
    position: {
      type: String,
    },
    controlPlan: {
      type: Object,
    },
  },
  data() {
    return {
      loading: true,
      fields: [],
      panels: [],
      imageOpen: false,
      noteOpen: false,
      measurement: null,
      imageUrl: "",
      field: {
        id: null,
        component_id: null,
        control_plan_id: null,
        position: null,
        anomaly: false,
        anomaly_notes: null,
        lubricant_levels: null,
        lubricant_appearence: null,
        temperature: null,
        pressure: null,
        leakage: null,
        rpm: null,
        vibrations_type_SPM: null,
        vibrations_type_SPM_1: null,
        vibrations_type_SISM_1:null,
        vibrations_type_SISM_2:null,
        vibrations_type_SISM_3:null
      }
    }
  },
  async mounted() {
    if (Nova.missingResource("measurements"))
      return this.$router.push({ name: "404" });

    const { data } = await Nova.request().get(
      `/nova-vendor/machines/measurements/${this.controlPlan.id}/${this.position}`
    );
    this.measurement = data.measurement;
    await this.getFields();
    await this.getImage();
  },
  methods: {
    /**
     * Get the available fields for the resource.
     */
    async getFields() {
      this.panels = [];
      this.fields = [];

      const {
        data: { panels, fields },
      } = await Nova.request().get(
        `/nova-api/measurements/${this.measurement.id}/update-fields`,
        {
          params: {
            editing: true,
            editMode: "update",
            viaResource: "components",
            position: this.position,
            viaResourceId: this.componentId,
            viaRelationship: "",
          },
        }
      );

      this.panels = panels;
      this.field.id = this.measurement.id;
      this.field.component_id = this.componentId;
      this.field.control_plan_id = this.controlPlan.id;
      this.field.position = this.position;
      this.fields = fields;
        for (const property in fields) {
            const field = fields[property];
            this.field[field.attribute] = field.value;
        }
      this.$emit('edit', this.field)
      this.loading = false;
    },
    async getImage() {
      const { data } = await Nova.request().get(
        `/nova-vendor/machines/measurements-image/${this.measurement.measurement_config_id}`
      );
      this.imageUrl = data.image;
    },
    updateNotes(notes) {
      this.field.anomaly_notes = notes;
      this.edit();
    },
    edit(){
      this.$emit('edit', this.field)
    },
    getFieldByAttribute(attribute) {
        const fi = _.find(this.fields, (f) => f.attribute === attribute)
      return fi === undefined;
    },
    openImage() {
      this.imageOpen = true;
    },
    closeImage() {
      this.imageOpen = false;
    },
    openNote() {
      this.noteOpen = true;
    },
    closeNote() {
      this.noteOpen = false;
    }

  },

  computed: {},
};
</script>

