<template>
  <modal @modal-close="handleClose">
    <div class="flex justify-center items-center h-screen">
      <div
        class="bg-white rounded-lg shadow-lg overflow-hidden"
        style="width: 800px;"
      >
        <div class="p-8">
        <div v-if="hasValue" class="flex justify-between items-center">
          <template v-if="shouldShowLoader">
            <ImageLoader
              :src="imageUrl"
              :maxWidth="maxWidth"
              :rounded="field.rounded"
              @missing="value => (missing = value)"
            />
          </template>

          <template v-if="field.value && !imageUrl">
            <card
              class="
                  flex
                  item-center
                  relative
                  border border-lg border-50
                  overflow-hidden
                  p-4
                "
            >
              <span class="truncate mr-3"> {{ field.value }} </span>

              <DeleteButton
                :dusk="field.attribute + '-internal-delete-link'"
                class="ml-auto"
                v-if="shouldShowRemoveButton"
                @click="confirmRemoval"
              />
            </card>
          </template>

          <p
            v-if="imageUrl"
            class="ml-3 flex items-center text-sm"
          >
            <DeleteButton
              :dusk="field.attribute + '-delete-link'"
              v-if="shouldShowRemoveButton"
              @click="confirmRemoval"
            />
          </p>
        </div>
        <h4 v-if="shouldShowField" class="mb-8">{{ __('Upload file') }}</h4>
        <span
          v-if="shouldShowField"
          class="form-file mr-4"

        >
          <input
            ref="fileField"
            :dusk="field.attribute"
            class="form-file-input select-none"
            type="file"
            :id="idAttr"
            name="name"
            @change="fileChange"
            :disabled="uploading"
            :accept="field.acceptedTypes"
          />

          <label
            :for="labelFor"
            class="cursor-pointer text-primary"
          >
              <font-awesome-icon icon="fa-solid fa-file-arrow-up" />
            </label>
        </span>

        <span v-if="shouldShowField" class="text-90 text-sm select-none">
            {{ currentLabel }}
        </span>
        </div>
        <div class="bg-white px-6 py-3 flex">
          <div class="flex items-center ml-auto">
            <button
              dusk="cancel-action-button"
              type="button"
              @click.prevent="handleClose"
              class="btn btn-link dim cursor-pointer text-80 ml-auto mr-6"
            >
              {{ __('Cancel') }}
            </button>

            <button
              type="button"
              @click.prevent="save"
              class="btn btn-default btn-primary"
            >
              {{ __('Save') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import ImageLoader from '../../../../../nova/resources/js/components/ImageLoader'
import DeleteButton from '../../../../../nova/resources/js/components/DeleteButton'
import { Errors } from 'laravel-nova'
export default {
  name: "ImageField",
  props: [
    "disabled",
    "value",
    "field",
    "resourceId"
  ],
  components: { DeleteButton, ImageLoader },
  data: () => ({
    file: null,
    fileName: '',
    removeModalOpen: false,
    deleted: false,
    uploading: false,
    uploadProgress: 0,
    resourceName: 'measurement-configs'
  }),
  mounted() {
    this.field.fill = formData => {
      let attribute = this.field.attribute;
      formData.append(attribute, this.file, this.fileName);
    }
  },

  methods: {
    fileChange(event) {
      let path = event.target.value
      let fileName = path.match(/[^\\/]*$/)[0]
      this.fileName = fileName
      this.file = this.$refs.fileField.files[0];
    },
    save() {
      this.$emit("edit", this.file, this.fileName);
      this.handleClose();
    },

    /**
     * Confirm removal of the linked file
     */
    confirmRemoval() {
      this.fileName = null;
      this.file = null;
      this.deleted = true;
    },

    /**
     * Close the upload removal modal
     */
    closeRemoveModal() {
      this.removeModalOpen = false
    },

    /**
     * Remove the linked file from storage
     */
    async removeFile() {
      this.uploadErrors = new Errors()

      const {
        resourceName,
        resourceId
      } = this


      const uri = `/nova-api/${resourceName}/${resourceId}/field/image`

      try {
        await Nova.request().delete(uri)
        this.closeRemoveModal()
        this.deleted = true
        this.$emit('file-deleted')
        Nova.success(this.__('The file was deleted!'))
      } catch (error) {
        this.closeRemoveModal()

        if (error.response.status == 422) {
          this.uploadErrors = new Errors(error.response.data.errors)
        }
      }
    },
    handleClose() {
      this.$emit('close');
    }
  },

  computed: {
    /**
     * The current label of the file field.
     */
    currentLabel() {
      return this.fileName || this.__('no file selected')
    },

    /**
     * The ID attribute to use for the file field.
     */
    idAttr() {
      return this.labelFor
    },

    /**
     * The label attribute to use for the file field.
     */
    labelFor() {
      return `file-${this.field.attribute}`
    },
    /**
     * Determine whether the field has a value.
     */
    hasValue() {
      return (
        Boolean(this.field.value || this.imageUrl) &&
        !Boolean(this.deleted) &&
        !Boolean(this.missing)
      )
    },

    /**
     * Determine whether the field should show the loader component.
     */
    shouldShowLoader() {
      return !Boolean(this.deleted) && Boolean(this.imageUrl)
    },

    /**
     * Determine whether the file field input should be shown.
     */
    shouldShowField() {
      return Boolean(!this.hasValue)
    },

    /**
     * Determine whether the field should show the remove button.
     */
    shouldShowRemoveButton() {
      return Boolean(this.field.deletable)
    },

    /**
     * Return the preview or thumbnail URL for the field.
     */
    imageUrl() {
      return this.field.previewUrl || this.field.thumbnailUrl
    },

    /**
     * Determine the maximum width of the field.
     */
    maxWidth() {
      return this.field.maxWidth || 320
    },
  },
}
</script>
