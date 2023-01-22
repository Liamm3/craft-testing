<template>
  <ul v-for="company in companies">
    <li>{{ company.title }} - {{ company.city }}</li>
  </ul>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { Company } from "../lib/";

export default defineComponent({
  props: {
    companies: Array as PropType<Company[]>
  },
});
</script>