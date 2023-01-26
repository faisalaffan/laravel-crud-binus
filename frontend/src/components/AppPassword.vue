<template>
  <div>
    <v-skeleton-loader v-if="skeleton" type="card-heading" />
    <v-text-field
      v-else
      :id="id"
      ref="appInput"
      v-model="valueAppTextField"
      :clearable="clearable"
      :disabled="disabled || loading"
      :hide-details="hideDetails"
      :label="label"
      :loading="loading"
      :placeholder="placeholder"
      :rules="rules"
      class="ma-0 pa-0 px-3"
      color="teal"
      dense
      flat
      hide-spin-buttons
      no-resize
      outlined
      :type="show ? 'text' : 'password'"
      :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
      @click:append="show = !show"
      @input="onInput"
      @keyup.enter="onEnter"
    >
      <template #[`append`]>
        <v-progress-circular
          v-if="loading"
          indeterminate
          width="3"
          color="teal"
          class="ma-0 pa-0 d-flex justify-center"
        />
      </template>
    </v-text-field>
  </div>
</template>

<script>
export default {
  name: "AppPassword",
  data() {
    return {
      show: false,
    };
  },
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    clearable: {
      type: Boolean,
      default: true,
    },
    hideDetails: {
      type: Boolean,
      default: false,
    },
    skeleton: {
      type: Boolean,
      default: false,
    },
    placeholder: {
      type: String,
      default: "Loading ...",
    },
    id: {
      type: String,
      default: "",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [String, Number],
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    rules: {
      type: Array,
      default: () => [],
    },
    color: {
      type: String,
      default: "teal",
    },
    cols: {
      type: String,
      default: "12",
    },
    xl: {
      type: String,
      default: "6",
    },
    lg: {
      type: String,
      default: "6",
    },
    md: {
      type: String,
      default: "6",
    },
    sm: {
      type: String,
      default: "12",
    },
  },
  computed: {
    valueAppTextField: {
      get() {
        return this.value;
      },
      set(val) {
        if (val === null) {
          val = "";
        }
        this.$emit("input", val);
      },
    },
  },
  methods: {
    onInput(val) {
      if (val === null) {
        val = "";
      }
      this.$emit("onInput", val);
    },
    onEnter(val) {
      if (val.target.value === "") {
        return;
      }
      if (val.target.value === null) {
        return;
      }
      this.$emit("onEnter", val.target.value);
    },
  },
};
</script>
