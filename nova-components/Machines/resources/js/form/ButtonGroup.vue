<template>
  <div>
    <input
      v-if="!disabled"
      type="hidden"
      class="w-full form-control form-input form-input-bordered"
      v-model="inputData"
    />

    <div class="flex items-center justify-end">
      <button
        v-for="(option, index) in options"
        :key="index"
        class="
          border
          font-bold
          text-sm
          px-2
          py-1
          outline-none
          focus:outline-none
          ease-linear
          transition-all
          duration-150
        "
        :class="{
          'hover:bg-primary-30% hover:text-white border-primary-30%':
            !disabled,
          'bg-primary-30% text-white': inputData === option.value,
          'bg-transparent text-primary-30%':
            inputData !== option.value || disabled,
          'text-gray-400 border-gray-400': disabled,
        }"
        type="button"
        @click="setValue(option.value)"
      >
        <span v-if="!icon">{{ option.label }}</span>
        <font-awesome-icon :icon="`fa-solid ${option.label}`" v-else />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ButtonGroup",
  props: ["disabled", "options", "icon", "inputData"],

  data() {
    return {

    };
  },
  mounted() {
    this.getOptions();
  },
  methods: {
    getOptions() {
      const options = [
        {
          value: 1,
          label: "fa-thumbs-up",
        },
        {
          value: 0,
          label: "fa-thumbs-down",
        },
      ];

      /* this.options =
        this.field !== undefined && this.field.options
          ? this.field.options
          : options;*/
    },

    setValue(value) {
        this.$emit('update:inputData', value);
    },
  },
};
</script>

<style scoped>
.active {
  background: red;
  color: #fff;
}
</style>
