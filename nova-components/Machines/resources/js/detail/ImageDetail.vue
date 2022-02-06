<template>
  <modal @modal-close="handleClose">
    <div class="flex justify-center items-center h-screen">
      <div
        class="bg-white rounded-lg shadow-lg overflow-hidden relative"
        style="width: 800px;"
      >
        <div class="cursor-pointer absolute text-xl" @click="handleClose" style="top: 0.25rem; right: 0.25rem;">
          <i class="fa-regular fa-circle-xmark" />
        </div>
        <div class="p-8">
          <div class="flex justify-between items-center">
            <ImageLoader
              :src="imageUrl"
              :maxWidth="800"
              :rounded="false"
            />
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import ImageLoader from '../../../../../nova/resources/js/components/ImageLoader'
export default {
  name: "ImageDetail",
  props: [
    "imageUrl",
  ],
  components: { ImageLoader },
  methods: {
    handleClose() {
      this.$emit('close');
    }
  },
}
</script>
