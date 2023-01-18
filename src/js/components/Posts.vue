<template>
  <ul v-for="post in posts">
    <li>
      <a href="#">{{ post.title }}</a>
    </li>
    {{ post.body }}
  </ul>
</template>

<script lang="ts">
  import { Post } from "../lib";
  import { defineComponent, PropType } from "vue";

  export default defineComponent({
    props: {
      posts: Array as PropType<Post[]>
    },
    mounted() {
      console.log(this.posts[0].body)
    }
  })
</script>
