<template>
  <h1 class="bg-red-500">Hallo Welt!</h1>
  <p>{{ title }}</p>
  <p>Counter {{ count }}</p>
  <button @click="count++">+</button>
  <button @click="count--">-</button>
</template>

<script lang="ts">
  export default {
    data() {
      return {
        count: 12
      }
    },
    props: {
      title: String
    }
  }
</script>

<style lang="scss" scoped>
  $font-size: 2rem;
  h1 {
    font-size: $font-size;
  }
</style>