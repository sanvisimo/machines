<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
      <input
        :id="field.name"
        type="hidden"
        class="w-full form-control form-input form-input-bordered"
        :class="errorClasses"
        :placeholder="field.name"
        v-model="value"
      />

      <div class="flex items-center justify-end">
        <button
          v-for="(option, index) in options"
          :key="index"
          class="
            border border-primary-30%
            hover:bg-primary-30% hover:text-white
            active:bg-purple-600
            font-bold
            px-2
            py-1
            text-md
            outline-none
            focus:outline-none
            ease-linear
            transition-all
            duration-150
          "
          :class="{
            'bg-primary-30%': value === option.value,
            'bg-transparent': value !== option.value,
            'text-white': value === option.value,
            'text-primary-30%': value !== option.value,
          }"
          type="button"
          @click="setValue(option.value)"
        >
          <span v-if="field.options">{{ option.label }}</span>
          <font-awesome-icon :icon="`fa-solid ${option.label}`" v-else />
        </button>
      </div>
      <p v-if="hasError" class="my-2 text-danger">
        {{ firstError }}
      </p>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],

  data() {
    return {
      value: null,
      options: [],
    };
  },
  mounted() {
    this.getOptions();
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value !== null ? this.field.value : "";
    },

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

      this.options = this.field.options ? this.field.options : options;
    },

    setValue(value) {
      this.value = value;
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || "");
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
