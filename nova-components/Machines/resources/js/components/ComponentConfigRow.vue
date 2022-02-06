<template>
  <tr>
    <td>
      <span class="text-90 font-normal text-lg mb-3">
        {{ name }}
      </span>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.lubricant_levels" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.lubricant_appearence" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.leakage" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.temperature" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.pressure" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.vibrations_type_SPM" @input="edit" />
        </div>
    </td>
    <td>
        <div class="flex justify-center items-center">
            <boolean-field v-model="field.vibrations_type_SISM" @input="edit" />
        </div>
    </td>
    <td>
      <div class="flex justify-center items-center text-primary cursor-pointer">
        <font-awesome-icon icon="fa-solid fa-file-image" @click="openModal" />
        <span class="ml-4" v-if="imageName"> {{ imageName }}</span>
        <portal to="modals">
          <image-field
            v-if="modalOpen"
            @close="closeModal"
            :value="image.value"
            :field="image"
            @edit="uploadImage"
            :resource-id="field.id"
          />
        </portal>
      </div>
    </td>
  </tr>
</template>

<script>
import BooleanField from "../form/BooleanField.vue";
import ImageField from "../form/ImageField";
export default {
  components: { BooleanField, ImageField },
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
      update: {
        type: Boolean
      }
  },
  data() {
    return {
      controlPlanId: null,
      loading: true,
      componentConfigId: null,
      fields: [],
      panels: [],
      image: {},
      modalOpen: false,
      imageField: null,
      imageName: null,
      field: {
        id: null,
        component_id: null,
        lubricant_levels: false,
        lubricant_appearence: false,
        leakage: false,
        temperature: false,
        pressure: false,
        vibrations_type_SPM: false,
        vibrations_type_SISM: false,
        image: null
      }
    };
  },
  async mounted() {
      if (Nova.missingResource('measurement-configs'))
          return this.$router.push({ name: '404' })

      await this.getFields()
  },
  methods: {
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
        this.field.id = this.componentConfigId;
        this.field.position = this.position;
        this.field.component_id = this.componentId;
        this.fields = _.map(fields, field => {
            this.field[field.attribute] = field.value;
            if(field.attribute === 'image'){
                const img = {
                    ...field,
                    attribute: 'image' + this.position,
                    sortableUriKey: 'image' + this.position,
                    validationKey: 'image' + this.position,
                }
                this.image = img;
                this.imageName = img.value;
                return img;
            }
            return field;
        })
        this.$emit('edit', this.field)
        this.loading = false
    },
    openModal() {
      this.modalOpen = true;
    },
    closeModal(){
      this.modalOpen = false
    },
    edit(){
      this.$emit('edit', this.field)
    },
    uploadImage(file, filename){
      this.imageName = filename;
      this.$emit('upload', file, this.position);
    },
    getFieldByAttribute(attribute) {
     return _.find(this.fields, (f) => f.attribute === attribute);
    },
  },

  computed: {},
};
</script>

