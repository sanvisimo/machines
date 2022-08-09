<template>
  <modal @modal-close="handleClose">
    <div class="flex justify-center items-center h-screen">
      <div
        class="bg-white rounded-lg shadow-lg overflow-hidden relative"
        style="width: 800px;"
      >
        <div class="pt-3 px-6 pb-4">
          <label class="text-80 pt-2 leading-tight mb-4">{{ __('Notes') }}</label>
          <textarea
            class="w-full form-control form-input form-input-bordered mt-4 h-auto"
            v-model="value"
          >
          </textarea>
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
export default {
  name: "NoteField",
  props: {
      notes:{
        type: String,
      },
  },
  data() {
    return {
      value: ""
    };
  },
  mounted() {
    this.value = this.notes
  },
  methods: {
    save(){
      this.$emit('update', this.value)
      this.handleClose();
    },
    handleClose(){
      this.$emit('close');
    }
  },
};
</script>
