<template>
  <modal
    tabindex="-1"
    role="dialog"
    @modal-close="handleClose"
  >
    <div class="flex justify-center items-center h-screen">
      <div
        class="bg-40 rounded-lg shadow-lg overflow-hidden p-8"
        style="width: 800px"
      >
        Questa è una modale
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  name: "ImageModal",
  methods: {
    /**
     * Close the modal.
     */
    handleClose() {
      this.$emit('close')
    },
  }
}
</script>

<style scoped>

</style>
