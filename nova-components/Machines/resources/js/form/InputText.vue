<template>
  <div>
    <input
      :type="type"
      class="w-full form-control form-input form-input-bordered"
      :disabled="disabled"
      @change="$emit('update:inputData', $event.target.value);"
      :placeholder="placeholder"
      :value="inputData"
    />
  </div>
</template>

<script>
export default {
  name: "InputText",
  props: {
    disabled: {
      type: Boolean,
    },
      inputData:{
        type: String,
      },
    placeholder: {
      type: String,
      default: "0",
    },
    type: {
      type: String,
      default: "text",
    },
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
