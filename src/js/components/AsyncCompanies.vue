<template>
  <ul v-for="company in companies">
    <li>{{ company.title }}</li>
  </ul>
  <pulse-loader :loading="loading"></pulse-loader>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import PulseLoader from "vue-spinner/src/PulseLoader.vue"
import { Company } from "../lib/";

export default defineComponent({
  components: {
    PulseLoader
  },
  data() {
    return {
      companies: [] as Company[],
      loading: true,
    }
  },
  async mounted() {
    const response = await fetch("/actions/site-module/company/");
    this.companies = await response.json();
    this.loading = false;
  }
});
</script>