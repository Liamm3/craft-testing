<template>
  <ul v-if="posts" v-for="post in posts">
    <li>
      <a :href="post.uri">{{ post.title }}</a>
    </li>
  </ul>
  <pulse-loader :loading="loading"></pulse-loader>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import PulseLoader from "vue-spinner/src/PulseLoader.vue"
import { Post } from "../lib";

export default defineComponent({
    data() {
      return {
        posts: [] as Post[],
        loading: true,
      }
    },
    components: {
      PulseLoader
    },
    mounted() {
      setTimeout(async () => {
        const response = await fetch('/actions/site-module/posts/');
        this.posts = await response.json();
        this.loading = false;
      }, 1000)
    }
  })
</script>
