<template>
  <v-btn
    v-if="type === 'new'"
    :color="color"
    small
    :disabled="disabled"
    :loading="loading"
    @click="$emit('onClick', $event)"
  >
    <span class="white--text mx-1">{{ 'new' }}</span>
    <v-icon color="white" small> mdi-plus </v-icon>
  </v-btn>
  <v-btn
    v-else-if="type === 'save'"
    color="#4D8FAC"
    small
    :disabled="disabled"
    :loading="loading"
    @click="$emit('onClick', $event)"
  >
    <span class="white--text mx-1">{{ 'save' }}</span>
    <v-icon color="white" small> mdi-content-save </v-icon>
  </v-btn>
  <v-btn
    v-else-if="type === 'print'"
    color="#F3C13A"
    small
    :disabled="disabled"
    :loading="loading"
    @click="$emit('onClick', $event)"
  >
    <span class="white--text mx-1">{{ 'print' }}</span>
    <v-icon color="white" small> mdi-printer </v-icon>
  </v-btn>
  <v-btn
    v-else-if="type === 'editIcon'"
    color="#3AB0FF"
    small
    :disabled="disabled"
    :loading="loading"
    @click="$emit('onClick', $event)"
  >
    <v-icon color="white" small> mdi-pencil </v-icon>
  </v-btn>
  <v-btn
    v-else-if="type === 'deleteIcon'"
    color="#E64848"
    small
    :disabled="disabled"
    :loading="loading"
    @click="$emit('onClick', $event)"
  >
    <v-icon color="white" small> mdi-delete </v-icon>
  </v-btn>
  <v-skeleton-loader v-else-if="type === 'loading'" type="button" />
  <v-btn v-else :color="colorCustom" @click="$emit('onClick', $event)" :disabled="disabled">
    <slot />
  </v-btn>
</template>

<script>
export default {
  name: 'AppBaseButton',
  props: {
    loading: {
      type: Boolean,
      default: false,
    },
    color: {
      type: String,
      default: 'teal',
    },
    colorCustom: {
      type: String,
      default: 'teal',
    },
    type: {
      type: String,
      default: 'example',
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
}
</script>
