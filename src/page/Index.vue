<template>
  <section class="main-container">
    <top-bar/>
    <router-view></router-view>
  </section>
</template>

<script>
  import TopBar from '../components/TobBar/TopBar.vue'

  export default {
    name: 'Index',
    components: {
      TopBar
    }
  }
</script>

<style>

</style>
